var count = 0


$(".addSection").click(function() {
    count++
    $(".sectionInput").append('<label for="titre' + count + '" class="form-label">Titre de la section</label><input type="text" name="titre' + count + '" class="form-control mb-4" id="titre' + count + '" required></input>');
});