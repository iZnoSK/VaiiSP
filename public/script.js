class Chat {
    async getReviews() {
        try {
            let response = await fetch("?c=movie&a=getReviews&id=" + document.getElementById('idOfMovie').value);
            let reviews = await response.json();
            let reviewsHTML = "";
            reviews.forEach(review => {
                reviewsHTML += `
                        <h6><strong>${review.user_login}</strong></h6>
                        <p>${review.re_text}</p>
                        <hr>`;
            })
            document.getElementById("reviews").innerHTML = reviewsHTML;
        } catch (e) {
            document.getElementById("reviews").innerHTML = `<h2>Nastala chyba na strane servera.</h2><p>${e.message}</p>`;
        }
    }

    async getRatings() {
        try {
            let response = await fetch("?c=movie&a=getRatings&id=" + document.getElementById('idOfMovie').value);
            let ratings = await response.json();
            let ratingsHTML = "";
            ratings.forEach(rating => {
                ratingsHTML += `<tr>
                                    <td class="prvyStlpecHodnotenia">${rating.user_login}</td>
                                    <td class="druhyStlpecHodnotenia">${rating.ra_percentage}</td>
                                </tr>`;
            })
            document.getElementById("ratings").innerHTML = ratingsHTML;
        } catch (e) {
            document.getElementById("ratings").innerHTML = `<h6>Nastala chyba na strane servera.</h6><p>${e.message}</p>`;
        }
    }

    async run() {
        setInterval(this.getReviews, 100000);
        await this.getReviews();
        setInterval(this.getRatings, 100000);
        await this.getRatings();
    }
}

window.onload = async function () {
    window.chat = new Chat();
    await window.chat.run();
    alert("The URL of this page is: " + window.location.href); //   http://localhost/Semestralka/?c=movie&a=getProfile&id=24
}