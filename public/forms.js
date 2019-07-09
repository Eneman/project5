var collectionHolder;

var addStbButton = $('<button type="button" class="add_stb_link">Ajouter Stb</button>');
var newLinkLi = $('<li></li>').append(addStbButton);

$(document).ready(function() {
    collectionHolder = $('ul.stbs');
    collectionHolder.append(newLinkLi);
    collectionHolder.data('index', collectionHolder.find(':input').length);

    addStbButton.on('click', function(e) {
        addStbForm(collectionHolder, newLinkLi);
    })
})