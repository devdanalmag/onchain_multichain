-- Migration: Add transaction_type, token_name, token_contract to transactions
-- Compatible with MySQL/MariaDB using INFORMATION_SCHEMA checks

START TRANSACTION;

-- Create procedure to add columns only if they do not already exist
DELIMITER $$
DROP PROCEDURE IF EXISTS add_transactions_columns$$
CREATE PROCEDURE add_transactions_columns()
BEGIN
  -- transaction_type
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = 'transactions' AND COLUMN_NAME = 'transaction_type'
  ) THEN
    ALTER TABLE transactions
      ADD COLUMN transaction_type VARCHAR(10) NOT NULL DEFAULT 'app' AFTER token_amount;
  END IF;

  -- token_name
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = 'transactions' AND COLUMN_NAME = 'token_name'
  ) THEN
    ALTER TABLE transactions
      ADD COLUMN token_name VARCHAR(64) NULL AFTER transaction_type;
  END IF;

  -- token_contract
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = 'transactions' AND COLUMN_NAME = 'token_contract'
  ) THEN
    ALTER TABLE transactions
      ADD COLUMN token_contract VARCHAR(66) NULL AFTER token_name;
  END IF;
END$$
DELIMITER ;

CALL add_transactions_columns();
DROP PROCEDURE add_transactions_columns;

-- Backfill defaults and create indexes (guarded by checks)
UPDATE transactions
SET transaction_type = 'app'
WHERE transaction_type IS NULL OR transaction_type = '';

-- Create index on transaction_type if missing
DELIMITER $$
DROP PROCEDURE IF EXISTS add_transactions_indexes$$
CREATE PROCEDURE add_transactions_indexes()
BEGIN
  -- idx_transactions_type
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_NAME = 'transactions' AND INDEX_NAME = 'idx_transactions_type'
  ) THEN
    CREATE INDEX idx_transactions_type ON transactions (transaction_type);
  END IF;

  -- idx_transactions_type_date
  IF NOT EXISTS (
    SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_NAME = 'transactions' AND INDEX_NAME = 'idx_transactions_type_date'
  ) THEN
    CREATE INDEX idx_transactions_type_date ON transactions (transaction_type, date);
  END IF;
END$$
DELIMITER ;

CALL add_transactions_indexes();
DROP PROCEDURE add_transactions_indexes;

COMMIT;

