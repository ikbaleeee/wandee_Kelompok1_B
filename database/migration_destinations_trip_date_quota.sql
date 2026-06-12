-- Tambahkan tanggal trip dan kuota peserta untuk destinasi.
-- Jalankan sekali jika tabel destinations belum memiliki kolom ini.

ALTER TABLE destinations
  ADD COLUMN IF NOT EXISTS trip_date varchar(100) DEFAULT NULL AFTER image,
  ADD COLUMN IF NOT EXISTS quota int DEFAULT 0 AFTER price;
