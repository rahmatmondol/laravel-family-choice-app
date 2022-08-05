$(function () {

  // Multiple images preview in browser
  var imagesPreview = function (input, placeToInsertImagePreview) {

    if (input.files) {
      var filesAmount = input.files.length;

      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();

        reader.onload = function (event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
        }

        reader.readAsDataURL(input.files[i]);
      }
    }

  };

  $('#gallery-photo-attachments').on('change', function () {
    imagesPreview(this, 'div.gallery_attachments');
  });


});

$('.btn').on('click', function () {
  var $this = $(this);

  $this.button('loading');
  setTimeout(function () {
    $this.button('reset');

  }, 1000);

});

function selects(status=true) {
  $("input[type=checkbox]").prop('checked', status);
}





