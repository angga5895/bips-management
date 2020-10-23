CREATE VIEW v_trades AS SELECT a.trade_date,
    a.market_order_id,
    a.base_account_no,
    a.side,
    a.trade_qty,
    a.price,
        CASE
            WHEN ((a.symbol_sfx)::text = '0NG'::text) THEN ((a.trade_qty)::numeric * a.price)
            ELSE (((a.trade_qty * 100))::numeric * a.price)
        END AS trade_value,
    b.source
   FROM trades a,
    v_order_all b
  WHERE ((a.market_order_id)::text = (b.market_order_id)::text);