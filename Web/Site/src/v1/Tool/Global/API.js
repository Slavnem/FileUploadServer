// Fetch
export class ApiService {
    // Veri Çekme
    static async FetchData(argUrl, argMethod, argParams = {}) {
        try {
            // Fetch isteğini başlat
            const response = await fetch(argUrl, {
                method: argMethod,
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8', // JSON türünde veri gönderiliyor
                    'Accept': 'application/json'
                },
                body: JSON.stringify(argParams)
            });

            // Yanıtın başarılı olup olmadığını kontrol et
            if (!response.ok) {
                const errorMessage = await response.text();
                throw new Error(`HTTP Error: ${response.status} - ${errorMessage}`);
            }

            // Yanıtı JSON formatında döndür
            const data = await response.json();
            return data;
        } catch (error) {
            // Hataları konsola yazdır
            console.error('Fetch Error:', error.message);
            return null; // Hata durumunda null döndür
        }
    }
}