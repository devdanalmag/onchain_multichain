-- Multi-Chain DEX Migration Script
-- Run this SQL to add support for Base, Arbitrum, and BSC chains
-- Generated: 2025-12-29

-- Step 1: Add new columns to existing blockchain table
ALTER TABLE `blockchain` 
ADD COLUMN `chain_key` VARCHAR(32) AFTER `id`,
ADD COLUMN `chain_id_hex` VARCHAR(10) AFTER `chain_id`,
ADD COLUMN `explorer_url` VARCHAR(255) AFTER `rpc_url`,
ADD COLUMN `native_symbol` VARCHAR(10) AFTER `explorer_url`,
ADD COLUMN `is_active` TINYINT(1) DEFAULT 1 AFTER `refunding_address`;

-- Step 2: Update existing AssetChain row
UPDATE `blockchain` SET 
  `chain_key` = 'assetchain',
  `chain_id_hex` = '0xa5b4',
  `explorer_url` = 'https://scan.assetchain.org',
  `native_symbol` = 'ASET',
  `is_active` = 1
WHERE `id` = 1;

-- Step 3: Add new chains (Base, Arbitrum, BSC)
INSERT INTO `blockchain` (`chain_key`, `name`, `rpc_url`, `chain_id`, `chain_id_hex`, `explorer_url`, `native_symbol`, `site_address`, `refunding_address`, `is_active`) VALUES
('base', 'Base Mainnet', 'https://mainnet.base.org', 8453, '0x2105', 'https://basescan.org', 'ETH', '0x89e6dfc44c1a31ded30fb16500409eaeca7cd2e6', '0x7ca40709d82c4df573c4eb0dc88cc9d16bbe0f53', 1),
('arbitrum', 'Arbitrum One', 'https://arb1.arbitrum.io/rpc', 42161, '0xa4b1', 'https://arbiscan.io', 'ETH', '0x89e6dfc44c1a31ded30fb16500409eaeca7cd2e6', '0x7ca40709d82c4df573c4eb0dc88cc9d16bbe0f53', 1),
('bsc', 'BNB Smart Chain', 'https://bsc-dataseed.binance.org/', 56, '0x38', 'https://bscscan.com', 'BNB', '0x89e6dfc44c1a31ded30fb16500409eaeca7cd2e6', '0x7ca40709d82c4df573c4eb0dc88cc9d16bbe0f53', 1);

-- Step 4: Add chain_id to tokens table
ALTER TABLE `tokens` ADD COLUMN `chain_id` INT DEFAULT 1 AFTER `is_active`;

-- Step 5: Update existing tokens to AssetChain (id=1)
UPDATE `tokens` SET `chain_id` = 1 WHERE `chain_id` IS NULL;

-- Step 6: Add sample tokens for other chains
-- Base chain (id=2)
INSERT INTO `tokens` (`token_name`, `token_contract`, `token_decimals`, `is_active`, `chain_id`) VALUES
('USDC', '0x833589fCD6eDb6E08f4c7C32D4f71b54bdA02913', 6, 1, 2),
('ETH', '0x4200000000000000000000000000000000000006', 18, 1, 2);

-- Arbitrum chain (id=3)
INSERT INTO `tokens` (`token_name`, `token_contract`, `token_decimals`, `is_active`, `chain_id`) VALUES
('USDC', '0xaf88d065e77c8cC2239327C5EDb3A432268e5831', 6, 1, 3),
('ETH', '0x82aF49447D8a07e3bd95BD0d56f35241523fBab1', 18, 1, 3);

-- BSC chain (id=4)
INSERT INTO `tokens` (`token_name`, `token_contract`, `token_decimals`, `is_active`, `chain_id`) VALUES
('USDT', '0x55d398326f99059fF775485246999027B3197955', 18, 1, 4),
('BNB', '0xbb4CdB9CBd36B01bD1cBaEBF2De08d9173bc095c', 18, 1, 4);
