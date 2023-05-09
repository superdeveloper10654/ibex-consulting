var valKeyDown,valKeyUp ;
var Load_anolyze = () =>{
    var i=0,j=0,k=0 ;
    var pro_tbody_obj = [] ;
    var sev_tbody_obj = [] ;
    var imp_tbody_score = [] ;
    var pro_tbody = $(".probability_table").children();
    var sev_tbody = $(".severity_table").children();
    var imp_tbody = $(".impact_table").children();
    for ( i = 1 ; i < pro_tbody.children().length ; i ++ ) {
        pro_tbody_obj.push({[$($(pro_tbody.children()[i]).children()[0]).children().val()]:$($(pro_tbody.children()[i]).children()[3]).children().val()}) ;
    }
    for ( i = 1 ; i < sev_tbody.children().length ; i ++ ){
        sev_tbody_obj.push({[$($(sev_tbody.children()[i]).children()[0]).children().val()] : $($(sev_tbody.children()[i]).children()[1]).children().val()}) ;
    }
    for ( i = 1 ; i < imp_tbody.children().length ; i ++ ){
        imp_tbody_score.push( 
            {
                "name": $($(imp_tbody.children()[i]).children()[0]).children().val(), 
                "val" : $($(imp_tbody.children()[i]).children()[1]).children().val(),
                "color": $($(imp_tbody.children()[i]).children()[2]).children().val()
            }
        );
    }
    imp_tbody_score.sort(function(a,b){
        return b.val-a.val ;
    });
    var risk_matrix_html = "" ;
    i = 0; j = 0 ;
    for (i = 0 ; i < pro_tbody_obj.length ; i ++ ){
        var pro_key = Object.keys(pro_tbody_obj[i])[0];
        var pro_value = Object.values(pro_tbody_obj[i])[0];
        if ( i == 0 ){
            risk_matrix_html += "<tr>";
            risk_matrix_html += "<td style='background: #ffffff'></td>";
            for(j = 0 ; j < sev_tbody_obj.length ; j ++){
              //  risk_matrix_html += `<td>${Object.keys(sev_tbody_obj[j])[0]}(${Object.values(sev_tbody_obj[j])[0]})</td>`;
                  risk_matrix_html += `<td>${Object.keys(sev_tbody_obj[j])[0]}</td>`;
            }
            risk_matrix_html += "</tr>";
            risk_matrix_html += "<tr>";
         // risk_matrix_html += `<td>${pro_key}(${pro_value})</td>`;
            risk_matrix_html += `<td>${pro_key}</td>`;
            for(j = 0 ; j < sev_tbody_obj.length ; j ++){
                var sev_key = Object.keys(sev_tbody_obj[j])[0];
                var sev_value = Object.values(sev_tbody_obj[j])[0];
                var multi = pro_value * sev_value ;
                var text = "N/A" ;
                var td_color = "#ffffff";
                for ( k = 0 ; k < imp_tbody_score.length ; k ++ ){
                    if( multi >= imp_tbody_score[k]["val"]){
                        text = imp_tbody_score[k]['name'];
                        td_color = imp_tbody_score[k]['color'];
                        break;   
                    }
                }
                if ( k != imp_tbody_score.length ) risk_matrix_html += `<td style = "background-color:${td_color};color:white;text-align: center">${text}(${multi})</td>`;
                else risk_matrix_html += `<td style = "background-color:${td_color};text-align:center">${text}</td>`;
            }
            risk_matrix_html += "</tr>";
        } else {
            risk_matrix_html += "<tr>";
         // risk_matrix_html += `<td>${pro_key}(${pro_value})</td>`;
            risk_matrix_html += `<td>${pro_key}</td>`;
            for(j = 0 ; j < sev_tbody_obj.length ; j ++){
                var sev_key = Object.keys(sev_tbody_obj[j])[0];
                var sev_value = Object.values(sev_tbody_obj[j])[0];
                var multi = pro_value * sev_value ;
                var text = "N/A" ;
                var td_color = "#ffffff";
                for ( k = 0 ; k < imp_tbody_score.length ; k ++ ){
                    if( multi >= imp_tbody_score[k]["val"]){
                        text = imp_tbody_score[k]['name'];
                        td_color = imp_tbody_score[k]['color'];
                        break;   
                    }
                }
                if ( k != imp_tbody_score.length ) risk_matrix_html += `<td style = "background-color:${td_color};color:white;text-align:center">${text}(${multi})</td>`;
                else risk_matrix_html += `<td style = "background-color:${td_color};text-align:center">${text}</td>`;
            }
            risk_matrix_html += "</tr>";
        }
    }
    $(".risk-matrix-body").html(risk_matrix_html);
}

// If input text, running nothing.
function integerOnly(e) {
    e = e || window.event;
    var code = e.which || e.keyCode;
    if (!e.ctrlKey) {
        var arrIntCodes1 = new Array(96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 8, 9, 116);   // 96 TO 105 - 0 TO 9 (Numpad)
        if (!e.shiftKey) {                          //48 to 57 - 0 to 9 
            arrIntCodes1.push(48);                  //These keys will be allowed only if shift key is NOT pressed
            arrIntCodes1.push(49);                  //Because, with shift key (48 to 57) events will print chars like @,#,$,%,^, etc.
            arrIntCodes1.push(50);
            arrIntCodes1.push(51);
            arrIntCodes1.push(52);
            arrIntCodes1.push(53);
            arrIntCodes1.push(54);
            arrIntCodes1.push(55);
            arrIntCodes1.push(56);
            arrIntCodes1.push(57);
        }
        var arrIntCodes2 = new Array(35, 36, 37, 38, 39, 40, 46);
        if ($.inArray(e.keyCode, arrIntCodes2) != -1) {
            arrIntCodes1.push(e.keyCode);
        }
        if ($.inArray(code, arrIntCodes1) == -1) {
            return false;
        }
    }
    return true;
}

$(function(){
    $(".textOnly").keydown(
        async function(obj){
            setTimeout( await function(){
                var input_val = obj.currentTarget.value ;
                var parent_obj = $(obj.currentTarget).parents("table");
                Load_anolyze();
                if ( parent_obj.hasClass("probability_table")){
                    
                } else if (parent_obj.hasClass("severity_table") ){

                } else {

                }
            },50);   
        }
    )
    $(".integerOnly").keydown(
        async function(obj){
        valKeyDown = this.value;
        if ( integerOnly(obj) == false ) return ;
        setTimeout( await function(){
            var input_val = obj.currentTarget.value ;
            var parent_obj = $(obj.currentTarget).parents("table");
            Load_anolyze();
            if ( parent_obj.hasClass("probability_table")){
                
            } else if (parent_obj.hasClass("severity_table") ){

            } else {

            }
        },50);  
    });
    $('.integerOnly').keyup(function (event) {  
               //This is to protect if user copy-pastes some character value ,..
        valKeyUp = this.value;
        if (!new RegExp('^[0-9]*$').test(valKeyUp) || valKeyUp > 100) {   //which is stored in 'valKeyDown' at keydown event.
            $(this).val(valKeyDown);                    //It is not possible to check this inside 'integerOnly' function as,
        }                                               //one cannot get the text printed by keydown event 
    });                                                 //(that's why, this is checked on keyup)
    
    $('.integerOnly').bind('input propertychange', function(e) {    //if user copy-pastes some character value using mouse
        valKeyUp = this.value;
        if (!new RegExp('^[0-9]*$').test(valKeyUp) || valKeyUp > 100) {
            $(this).val(valKeyDown);
        }
    });
});