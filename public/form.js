var collectionHolder;
var addStbButton = $('<button type="button" class="add_stb_link btn btn-primary btn-block">Ajouter Stb</button>');
var newLinkLi = $('<li class="list-group-item mb-3 bg-transparent border-0"></li>').append(addStbButton);

$(document).ready(function() {
    collectionHolder = $('ul.stbs');
    collectionHolder.find('div.stb.card').each(function() {
        addStbFormDeleteLink($(this).parent());
    });
    collectionHolder.append(newLinkLi);
    collectionHolder.data('index', collectionHolder.find(':input').length);

    addStbButton.on('click', function(e) {
        addStbForm(collectionHolder, newLinkLi);
        updateChoices('.choicejs.new');
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
    var $newFormDiv = $('<div class="stb card border-0 p-0 m-0"></div>').append(newForm)
    var $newFormLi = $('<li class="list-group-item mb-3 rounded"></li>').append($newFormDiv);
    $newLinkLi.before($newFormLi);
    addStbFormDeleteLink($newFormLi);
}

function addStbFormDeleteLink($stbFormLi) {
    var $removeFormButton = $('<button type="button" class="btn btn-danger btn-block">Supprimer</button>');
    $stbFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        if(confirm('Etes-vous sur de vouloir supprimer ce STB ?'))
        {
            $stbFormLi.remove();
        }
    });
}