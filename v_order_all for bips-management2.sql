CREATE VIEW v_order_all AS SELECT orders.order_date,
    orders.base_account_no,
    orders.server_order_id,
    orders.server_order_id AS primary_server_order_id,
    orders.market_order_id,
    orders.symbol_sfx,
    orders.side,
    orders.order_qty,
    orders.price,
        CASE
            WHEN ((orders.symbol_sfx)::text = '0NG'::text) THEN ((orders.order_qty)::numeric * orders.price)
            ELSE (((orders.order_qty * 100))::numeric * orders.price)
        END AS order_value,
    orders.source
   FROM orders
UNION
 SELECT v_order_amend.order_date,
    v_order_amend.base_account_no,
    v_order_amend.server_order_id,
    v_order_amend.primary_server_order_id,
    v_order_amend.market_order_id,
    v_order_amend.symbol_sfx,
    v_order_amend.side,
    v_order_amend.order_qty,
    v_order_amend.price,
    v_order_amend.order_value,
    v_order_amend.source
   FROM v_order_amend;