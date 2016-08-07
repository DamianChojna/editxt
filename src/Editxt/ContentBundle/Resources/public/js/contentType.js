
var $collectionHolder = $('#editxt_contentbundle_content_contentRelated');
var $addTextBlockLink = $('.add_text_block');

jQuery(document).ready(function() {

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTextBlockLink.on('click', function(e) {
        e.preventDefault();
        addTextBlockForm($collectionHolder);
    });
});

function addTextBlockForm($collectionHolder, $container, callback) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var newForm = $(prototype.replace(/__name__/g, index));
    $collectionHolder.data('index', index + 1);

    if (typeof callback === 'function') {
        callback(newForm);
    }

    if (typeof $container !== 'undefined') {
        $container.append(newForm);
    }else {
        $collectionHolder.append(newForm);
    }
}

$('body').on('click', '.contend_related .button.open', function () {
    Editxt.modal.modal('show');
    var $bodyDiv = Editxt.modal.find('.body');
    var $titleDiv = Editxt.modal.find('.title');

    var $contend_related = $(this).closest('.field.contend_related');
    var weight = $contend_related.find('[name*="weight"]').val();

    var date = new Date().getTime();
    var id = $(this).data('id')+date;
    $contend_related.addClass($contend_related.attr('id')+' '+id);
    Editxt.modal.attr('data-handler', JSON.stringify({'id':id, 'weight' : weight}));

    var jqxhr = $.get(Routing.generate('item'), function(result) {
        $bodyDiv.html(result);

        $bodyDiv.on('click', 'a', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');

            $.get(href, function(result) {
                $bodyDiv.html(result);
            });
        });

        $bodyDiv.on('submit', 'form', function(e) {
            e.preventDefault();
            var args = $(this).serialize();
            var href = $(this).attr('action');

            $.get(href+'?'+args, function(result) {
                $bodyDiv.html(result);
            });
        });
    })
    .done(function() {
        Editxt.modal.find('.dimmer').removeClass('active');
    })
    .fail(function() {
        alert( "Error Connection" );
    });
});

$('body').on('click', '.content_item_list .button.open', function(e) {
    e.preventDefault();
    dataHandler = JSON.parse(Editxt.modal.attr('data-handler'));
    $container = $('.'+dataHandler.id).parent('div');

    var id = $(this).data('id');
    var body = $(this).data('body');
    var title = $(this).data('title');
    var tags = $(this).data('tags');
    var subTitles = $(this).data('subtitles');

    $container.empty().html('');

    addTextBlockForm($collectionHolder, $container, function(newForm) {
        newForm.find('[name*="itemId"]').val(id);
        newForm.find('[name*="body"]').val(body);
        newForm.find('[name*="title"]').val(title);
        newForm.find('[name*="subTitles"]').val(subTitles);
        newForm.find('[name*="tags"]').val(tags);
        newForm.find('[name*="weight"]').val(dataHandler.weight);
    });

    Editxt.modal.modal('hide');
});

$('body').on('click', '.contend_related .button.duplicate', function(e) {
    e.preventDefault();
    $container = $(this).closest('.contend_related').parent('div');
    var title = $container.find('[name*="title"]').val();
    var subTitles = $container.find('[name*="subTitles"]').val();
    var body =  $container.find('[name*="body"]').val();
    var tags = $container.find('[name*="tags"]').val();
    var weight = $container.find('[name*="weight"]').val();

    $container.empty().html('');

    addTextBlockForm($collectionHolder, $container, function(newForm) {
        newForm.find('[name*="title"]').val(title);
        newForm.find('[name*="subTitles"]').val(subTitles);
        newForm.find('[name*="body"]').val(body);;
        newForm.find('[name*="tags"]').val(tags);
        newForm.find('[name*="weight"]').val(weight);
    });
});

$('body').on('click', '.button.remove', function () {

    $(this).closest('.contend_related ').fadeOut(500 ,function(){
        $(this).remove();
    });

});




