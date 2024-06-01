

    if (auth_level!=3) {

        $(".rest-sb-other").addClass('greyed-out').on('click', function(e){
            e.preventDefault();
        })

    }

    if(auth_level==1){
        $(".rest-sb-other-one").addClass('greyed-out').on('click', function(e){
            e.preventDefault();
        })
    }

    if(auth_level==3){
        $(".rest-sb-two-three-other").hide()
    
    }

