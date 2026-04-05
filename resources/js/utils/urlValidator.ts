export const isValidImageUrl = (url: string): boolean => {
  try {
    const parsedUrl = new URL(url);
    
    // Hanya izinkan protokol http dan https
    if (parsedUrl.protocol !== 'http:' && parsedUrl.protocol !== 'https:') {
      return false;
    }
    
    // Periksa ekstensi file gambar yang umum
    const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg'];
    const lowerCasePath = parsedUrl.pathname.toLowerCase();
    
    return imageExtensions.some(ext => lowerCasePath.endsWith(ext));
  } catch {
    // Jika URL tidak valid, kembalikan false
    return false;
  }
};

export const sanitizeUrl = (url: string): string => {
  // Untuk URL yang di-generate oleh URL.createObjectURL(), tidak perlu sanitasi
  if (url.startsWith('blob:')) {
    return url;
  }
  
  // Untuk URL eksternal, pastikan itu valid sebelum digunakan
  if (isValidImageUrl(url)) {
    return url;
  }
  
  // Kembalikan URL kosong jika tidak valid
  return '';
};
