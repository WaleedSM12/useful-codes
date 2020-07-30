let url = "{{route('admin.usertypes.destroy',':id')}}";
        url = url.replace(':id' , id);
        var x = document.getElementsByName("csrf-token");
        //var csrfToken = document.querySelector('meta//[name="csrf-token"]'); 
        const csrf = x[0].getAttribute('content');
