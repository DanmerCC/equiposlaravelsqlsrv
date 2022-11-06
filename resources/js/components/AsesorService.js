const { default: axios } = require("axios");

class AsesorService {
    list(page = 1, limit = 30, search = null) {
        let config = {
            params: {
                page,
                limit,
                search
            }
        };

        return new Promise((mapper, reject) => {
            axios
                .get(`/api/asesor`, config)
                .then(response => {
                    if (response.data.status) {
                        mapper(response.data.data);
                    } else {
                        console.log("Error:");
                        console.log(response);
                        reject(response);
                    }
                })
                .catch(reject);
        });
    }
}
export default new AsesorService();
