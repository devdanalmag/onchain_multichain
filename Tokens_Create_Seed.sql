-- Create tokens table and seed CNGN/USDT
START TRANSACTION;

CREATE TABLE IF NOT EXISTS tokens (
  token_id INT AUTO_INCREMENT PRIMARY KEY,
  token_name VARCHAR(64) NOT NULL,
  token_contract VARCHAR(66) NOT NULL,
  token_decimals INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  is_active TINYINT(1) NOT NULL DEFAULT 1
);

-- Indexes
DELIMITER $$
DROP PROCEDURE IF EXISTS add_tokens_indexes$$
CREATE PROCEDURE add_tokens_indexes()
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_NAME = 'tokens' AND INDEX_NAME = 'idx_token_name'
  ) THEN
    CREATE INDEX idx_token_name ON tokens (token_name);
  END IF;

  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_NAME = 'tokens' AND INDEX_NAME = 'idx_token_contract'
  ) THEN
    CREATE INDEX idx_token_contract ON tokens (token_contract);
  END IF;
END$$
DELIMITER ;

CALL add_tokens_indexes();
DROP PROCEDURE add_tokens_indexes;

-- Seed CNGN and USDT (idempotent upsert)
INSERT INTO tokens (token_name, token_contract, token_decimals, is_active)
SELECT 'CNGN', LOWER('0x7923c0f6fa3d1ba6eafcaedaad93e737fd22fc4f'), 6, 1
WHERE NOT EXISTS (SELECT 1 FROM tokens WHERE token_name='CNGN');

INSERT INTO tokens (token_name, token_contract, token_decimals, is_active)
SELECT 'USDT', LOWER('0x26E490d30e73c36800788DC6d7415946C4BbEa24'), 18, 1
WHERE NOT EXISTS (SELECT 1 FROM tokens WHERE token_name='USDT');

COMMIT;
