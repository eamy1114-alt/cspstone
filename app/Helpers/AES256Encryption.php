<?php

namespace App\Helpers;

class AES256Encryption
{
    private static $key;
    private static $cipher = 'AES-256-CBC';
    
    /**
     * Inisialisasi kunci enkripsi dari .env
     */
    private static function getKey()
    {
        if (!self::$key) {
            // Ambil kunci dari .env
            $key = env('ENCRYPTION_KEY', 'rekammedis2025superaessecretkey32');
            
            // Pastikan panjang kunci 32 byte (256 bit)
            self::$key = substr(hash('sha256', $key, true), 0, 32);
        }
        return self::$key;
    }
    
    /**
     * Enkripsi data ke AES-256
     */
    public static function encrypt($plaintext)
    {
        if ($plaintext === null || $plaintext === '') {
            return $plaintext;
        }
        
        try {
            $key = self::getKey();
            $iv = random_bytes(16); // 16 byte IV untuk AES-256-CBC
            
            $encrypted = openssl_encrypt($plaintext, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);
            
            // Gabungkan IV + encrypted data, lalu encode ke base64
            $combined = $iv . $encrypted;
            return base64_encode($combined);
        } catch (\Exception $e) {
            // Jika enkripsi gagal, kembalikan data asli
            return $plaintext;
        }
    }
    
    /**
     * Dekripsi data dari AES-256
     */
    public static function decrypt($ciphertext)
    {
        if ($ciphertext === null || $ciphertext === '') {
            return $ciphertext;
        }
        
        // Cek apakah ini data terenkripsi (dimulai dengan "AES:")
        if (!str_starts_with($ciphertext, 'AES:')) {
            // Jika tidak ada prefix, coba deteksi format base64
            if (self::isBase64Encoded($ciphertext)) {
                $decoded = base64_decode($ciphertext);
                if (strlen($decoded) > 16) {
                    try {
                        $iv = substr($decoded, 0, 16);
                        $encrypted = substr($decoded, 16);
                        $key = self::getKey();
                        $decrypted = openssl_decrypt($encrypted, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);
                        return $decrypted !== false ? $decrypted : $ciphertext;
                    } catch (\Exception $e) {
                        return $ciphertext;
                    }
                }
            }
            return $ciphertext;
        }
        
        try {
            // Hapus prefix "AES:"
            $data = substr($ciphertext, 4);
            $decoded = base64_decode($data);
            
            $iv = substr($decoded, 0, 16);
            $encrypted = substr($decoded, 16);
            $key = self::getKey();
            
            $decrypted = openssl_decrypt($encrypted, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);
            
            return $decrypted !== false ? $decrypted : $ciphertext;
        } catch (\Exception $e) {
            return $ciphertext;
        }
    }
    
    /**
     * Cek apakah string adalah base64
     */
    private static function isBase64Encoded($str)
    {
        if (!is_string($str)) return false;
        return base64_encode(base64_decode($str, true)) === $str;
    }
}