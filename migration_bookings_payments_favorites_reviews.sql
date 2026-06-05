-- Migration untuk memperbarui schema booking, payment, favorite, dan review agar terintegrasi dengan destinasi

ALTER TABLE bookings
  DROP FOREIGN KEY IF EXISTS bookings_ibfk_2,
  DROP INDEX IF EXISTS trip_id,
  CHANGE COLUMN trip_id destination_id int DEFAULT NULL,
  ADD COLUMN trip_status enum('new','ongoing','completed','cancelled') DEFAULT 'new' AFTER payment_status;

ALTER TABLE favorites
  DROP FOREIGN KEY IF EXISTS favorites_ibfk_2,
  DROP INDEX IF EXISTS trip_id,
  CHANGE COLUMN trip_id destination_id int DEFAULT NULL;

ALTER TABLE reviews
  DROP FOREIGN KEY IF EXISTS reviews_ibfk_2,
  DROP INDEX IF EXISTS trip_id,
  CHANGE COLUMN trip_id destination_id int DEFAULT NULL;

ALTER TABLE payments
  ADD COLUMN payment_amount int DEFAULT NULL AFTER payment_method,
  ADD COLUMN unique_code int DEFAULT NULL AFTER payment_amount;
