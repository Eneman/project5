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

function addStbForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}