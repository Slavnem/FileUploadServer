// Fetch
export class ApiService {
    // Veri Çekme
    static async FetchData(argUrl, argMethod, argParams = {}) {
        try {
            // fetch zamanlayıcı (10 saniye)
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);
            
            // ayarlar
            const options = {
                method: argMethod,
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(argParams),
                signal: controller.signal
            };
    
            // fetch sorgusu
            const response = await fetch(argUrl, options);
    
            // zaman aşımı zamanlayıcı temizle
            clearTimeout(timeoutId);

            // yanıtın başarılı olup olmadığını kontrol et
            if (!response.ok) {
                const errorMessage = await response.text();
                throw new Error(`HTTP Error: ${response.status} - ${errorMessage}`);
            }
    
            // yanıtı json olarak döndür
            const data = await response.json();
            return data;
        } catch (error) {
            // Hataları konsola yazdır
            console.error('Fetch Error:', error.message);
            return null; // Hata durumunda null döndür
        }
    }
}