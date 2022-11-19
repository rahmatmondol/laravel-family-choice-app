// $(document).ready(function () {
  //delete modal
  let confirmDeleteButton  = $('.confirm-delete');
  confirmDeleteButton.click(function (e) {
    var that = $(this)
    e.preventDefault();
    var n = new Noty({
      text: window.confirmOperation,
      type: "warning",
      killer: true,

      buttons: [
        Noty.button(`&nbsp;&nbsp;&nbsp; ${window.Yes}`,
          'btn btn-danger mr-2 fa fa-trash ui-button',
          function () {

            that.closest('form').submit();

          }),
        Noty.button(`&nbsp;&nbsp;&nbsp;  ${window.No}`,
          'btn btn-primary mr-2 fa fa-close',
          function () {
            n.close();
          })
      ]
    });
    n.show();
  }); //end of delete
  confirmDeleteButton.prop('disabled', false);
  // image preview
  for (let index = 0; index < 4; index++) {
    $(`.image${index}`).change(function () {
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $(`.image-preview${index}`).attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
      }
    });
  }
// })
