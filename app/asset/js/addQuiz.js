var count = 0


$(".addRep").click(function() {
    if (count <= 2) {
        count++
        $(".sectionInput").append('<label for="mauvaise-rep' + count + '" class="form-label">Mauvaise réponse n°' + count + '</label><input type="text" name="mauvaise-rep' + count + '" class="form-control mb-4" id="mauvaise-rep' + count + '" required></input>');
    } else {
        $(".sectionInput").append('<p class="errorMessage" style="color: red; font-size: 18px; margin-top: 15px">Maximum de mauvaises questions atteint </p>');
        $(".addRep").css("display", "none")
    }
});