$("document").ready(function() {

    $("#password").on('input', function(e) {

        if (/^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/.test(this.value)) {

            $("small").css("color", "green")
        } else {
            $("small").css("color", "red")
        }
    })

    $("#nom").on('input', function(e) {

        if (/^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$/.test(this.value)) {

            $(".validNom").css("display", "none")
        } else {
            $(".validNom").css("display", "block")
        }
    })

    $("#prenom").on('input', function(e) {

        if (/^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$/.test(this.value)) {

            $(".validPrenom").css("display", "none")
        } else {
            $(".validPrenom").css("display", "block")
        }
    })
})