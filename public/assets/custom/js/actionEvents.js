window.authorEvents = {
    'click .edit-data': function (e, value, row) {

        // console.log("hello");


        // console.log(row);
         // Get the data-user-id from the clicked button
         var userId = $(e.currentTarget).data('user-id');
         var authorId = $(e.currentTarget).data('id');

        $('#telegram_link').val(row.telegram_link);
        $('#whatsapp_link').val(row.whatsapp_link);
        $('#linkedin_link').val(row.linkedin_link);
        $('#facebook_link').val(row.facebook_link);


         // Set the hidden input values
         $('#edit_id').val(authorId);
         $('#user_id').val(userId);

         // Set the form action URL with the correct ID
        //  var form = $('#update_form');
        //  var actionUrl = form.attr('action').replace(/\/\d+$/, '/' + authorId);
        //  form.attr('action', actionUrl);

         // Set the status radio button if needed
         if (row.status) {
             $('input[name="author_status"][value="' + row.status + '"]').prop('checked', true);
         }
    },
};
