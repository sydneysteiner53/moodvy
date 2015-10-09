/**
 * Created by Sydney on 10/8/15.
 */

$(document).ready(function(){
    /**
     * Switching between Genre & Chart
     * @type {number}
     */
    $counter = 0;
    $cnt = 0;
//chart is clicked
    $("#chart").click(function(){
        if($cnt %2 == 1){
            $cnt = $cnt + 1;
            $( "#genres" ).toggleClass("togglegenres", 500);
        }

        $counter = $counter +1;

        $("#topmovies").toggleClass("toggletopmovies", 500);
    });



    if(typeof(loadpopup) !== "undefined"){
        $cnt = $cnt + 1;
        $( "#genres" ).toggleClass("togglegenres", 500);
    }


//genre is clicked


    $("#genre").click(function(){
        if($counter %2 == 1){
            $counter ++;
            $( "#topmovies" ).toggleClass("toggletopmovies", 500);
        }

        $cnt = $cnt +1;


        $("#genres").toggleClass("togglegenres", 500);
    });

//background is clicked

    $(".intro").click(function(){
        if($counter %2 == 1){
            if($cnt %2 == 1){
                $cnt = $cnt + 1;
                $( "#genres" ).toggleClass("togglegenres", 500);
            }



            $counter = $counter + 1;
            $( "#topmovies" ).toggleClass("toggletopmovies", 500);
        }

        if($cnt %2 == 1){
            $cnt = $cnt + 1;
            $( "#genres" ).toggleClass("togglegenres", 500);
        }
    });

    /**
     * Genre List
     */


    $("#g1").click(function(){
         //TODO: TONI OVER HERE

        $.ajax({
            url: "movies.php?genre=",
            context: document.body
        }).done(function() {
            $( this ).addClass( "done" );
        });

    });

});