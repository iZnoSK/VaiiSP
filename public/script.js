class Controller {
    async getReviews() {        //The word “async” before a function means one simple thing: a function always returns a promise.
        try {
            let response = await fetch("?c=movie&a=getReviews&id=" + document.getElementById('idOfMovie').value);
            let reviews = await response.json();
            let reviewsHTML = "";
            reviews.forEach(review => {
                reviewsHTML += `
                        <h6><strong><a href="?c=user&a=getProfile&id=${review.user_id}">${review.user_login}</a></strong></h6>
                        <p>${review.re_text}</p>
                        <hr>`;
            })
            document.getElementById("reviews").innerHTML = reviewsHTML;
        } catch (error) {
            document.getElementById("reviews").innerHTML = `<h6>Na strane servera nastala takáto chyba:</h6><p>${error.message}</p>`;
        }
    }

    async addReview() {
        try {
            let review = document.getElementById("review").value;
            if(review.trim().length === 0) {
                document.getElementById("review").value = "";
                alert("Snažíte sa poslať prázdnu recenziu");
                return;
            }
            let response = await fetch(
                "?c=movie&a=addReview&movieId=" + document.getElementById('idOfMovie').value,
                {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    method: "POST",
                    body: "reviewOfMovie=" + review
                });
            let responseJSON = await response.json();
            if(responseJSON === "success") {
                document.getElementById("reviewForm").remove();
                alert("Vaša recenzia bola pridaná");
            }
            if(responseJSON === "error") {
                document.getElementById("review").value = "";
                alert("Snažíte sa poslať prázdnu recenziu");
            }
        } catch (error) {
            document.getElementById("reviewForm").innerHTML = `<h6>Na strane servera nastala takáto chyba:</h6><p>${error.message}</p>`;
        }
    }

    async getRatings() {
        try {
            let response = await fetch("?c=movie&a=getRatings&id=" + document.getElementById('idOfMovie').value);
            let ratings = await response.json();
            let ratingsHTML = "";
            ratings.forEach(rating => {
                ratingsHTML += `<tr>
                                    <td class="prvyStlpecHodnotenia"><a href="?c=user&a=getProfile&id=${rating.user_id}">${rating.user_login}</td>
                                    <td class="druhyStlpecHodnotenia">${rating.ra_percentage}</td>
                                </tr>`;
            })
            document.getElementById("ratings").innerHTML = ratingsHTML;
        } catch (error) {
            document.getElementById("ratings").innerHTML = `<h6>Na strane servera nastala takáto chyba:</h6><p>${error.message}</p>`;
        }
    }

    async addRating() {
        try {
            let rating = document.getElementById("rating").value;
            if(rating.length === 0 || rating < 1 || rating > 100 ) {
                document.getElementById("rating").value = "";
                alert("Hodnotenie musí byť číslo medzi 0-100%");
                return;
            }
            let response = await fetch(
                "?c=movie&a=addRating&movieId=" + document.getElementById('idOfMovie').value,
                {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    method: "POST",
                    body: "ratingOfMovie=" + rating
                });
            let responseJSON = await response.json();
            if(responseJSON === "success") {
                document.getElementById("ratingForm").remove();
                alert("Vaše hodnotenie bolo pridané");
            }
            if(responseJSON === "error") {
                document.getElementById("rating").value = "";
                alert("Hodnotenie musí byť číslo medzi 0-100%");
            }
        } catch (error) {
            document.getElementById("ratingForm").innerHTML = `<h6>Na strane servera nastala takáto chyba:</h6><p>${error.message}</p>`;
        }
    }

    async reload() {
        setInterval(this.getReviews, 2000);
        setInterval(this.getRatings, 2000);
        await this.getRatings();
        await this.getReviews();
    }
}

class Validation {
    checkInput() {
        let login = document.getElementById("login");
        let pwd = document.getElementById("pwd");

        let loginValue = login.value.trim();
        let passwordValue = pwd.value.trim();
        //check login
        if(loginValue === "") {
            this.onError(login,"Používateľské meno nemôže byť prázdne");
        } else if(!this.isValidLogin(loginValue)) {
            this.onError(login,"Používateľské meno nie je v správnom tvare");
        } else {
            this.onSuccess(login);
        }
        //check password
        if(passwordValue === "") {
            this.onError(pwd,"Heslo nemôže byť prázdne");
        } else {
            this.onSuccess(pwd);
        }
        //check form
        this.checkForm();
    }

    onSuccess(input) {
        let formControl = input.parentElement;
        let messageEle = formControl.querySelector("small");
        messageEle.style.visibility="hidden";
        formControl.classList.remove("error");
        formControl.classList.add("success");
    }

    onError(input,message) {
        let formControl = input.parentElement;
        let messageEle = formControl.querySelector("small");
        messageEle.style.visibility = "visible";
        messageEle.innerText = message;
        formControl.classList.add("error");
        formControl.classList.remove("success");
    }

    isValidLogin(login){
        return login.match(/^[a-zA-Z0-9]*$/);
    }

    checkForm(){
        if (document.querySelectorAll(".error").length === 0) {
            document.getElementById("submit").disabled = false;
        } else {
            document.getElementById("submit").disabled = true;
        }
    }
}

window.onload = async function () {
    if(window.location.href === "http://localhost/Semestralka/?c=auth&a=loginForm") {
        this.validation = new Validation();
        this.validation.checkInput();
    }

    this.controller = new Controller();
    await this.controller.reload();

    let buttons = document.getElementsByTagName('button');
    for (let button of buttons) {
        if(button === document.getElementById('sendRating')) {
            document.getElementById("sendRating").onclick = () => {
                this.controller.addRating();
            }
        } else {
            document.getElementById("sendReview").onclick = () => {
                this.controller.addReview();
            }
        }
    }
    //;  //   http://localhost/Semestralka/?c=movie&a=getProfile&id=24
}

oninput  = function () {
    if(window.location.href === "http://localhost/Semestralka/?c=auth&a=loginForm") {
        this.validation = new Validation();
        this.validation.checkInput();
    }
}