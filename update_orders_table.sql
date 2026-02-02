-- Add status column to orders table if it doesn't exist
ALTER TABLE orders ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER total;
