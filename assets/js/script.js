$(document).ready(function () {
    var targetSize = "42"; // La taille cible que vous souhaitez compter

    $.ajax({
        url: "count_products_by_size.php",
        type: "POST",
        data: { size: targetSize },
        success: function (data) {
            $("#product-count").html("Nombre de produits avec la taille " + targetSize + " : " + data);
        },
        error: function () {
            $("#product-count").html("Erreur lors de la récupération du nombre de produits.");
        }
    });
});
