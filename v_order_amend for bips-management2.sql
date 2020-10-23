CREATE VIEW v_order_amend AS SELECT a.order_date,
    b.base_account_no,
    a.server_order_id,
    a.primary_server_order_id,
    a.market_order_id,
    b.symbol_sfx,
    b.side,
    a.order_qty,
    a.price,
        CASE
            WHEN ((b.symbol_sfx)::text = '0NG'::text) THEN ((a.order_qty)::numeric * a.price)
            ELSE (((a.order_qty * 100))::numeric * a.price)
        END AS order_value,
    b.source
   FROM order_chain a,
    orders b
  WHERE (((a.chain_type)::text = 'A'::text) AND ((a.primary_server_order_id)::text = (b.server_order_id)::text));