/**
 * Created by Lenaic on 09/05/2016.
 */
$('#randonnee_filter_form_name').autocomplete({
    source: function(term, response){
        // console.log(term);
        $.getJSON('/json/'+term.term, function(data){
            var noms = new Array();
            $.each(data, function(i, field){
                noms.push(field.name);
                //console.log(field.name);
            });
            response(noms);
        });
    }
});