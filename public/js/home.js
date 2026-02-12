$(function () {

    $(document).ready(function () {

        var route = $("#page").data("url");

        var params = {
            type: "GET",
            url: route+"/home/getChartTicket",
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                console.log(data);
                Morris.Line({element:"visitors-line-chart",
                    data:data,
                    xkey:"x",
                    ykeys:["y","z"],
                    xLabelFormat:function(e){
                        return(e=getMonthName(e.getMonth())).toString()
                    },
                    labels:["Page Views","Unique Visitors"],
                    lineColors:["#5AC8FA","#007aff"],
                    pointFillColors:["#63a4c1","#3086e4"],
                    lineWidth:"2px",
                    pointStrokeColors:["rgba(0,0,0,0.6)","rgba(0,0,0,0.6)"],
                    resize:!0,
                    gridTextFamily:"inherit",
                    gridTextColor:"rgba(255,255,255,0.4)",
                    gridTextWeight:"normal",
                    gridTextSize:"12px",
                    gridLineColor:"rgba(255,255,255,0.15)",
                    hideHover:"auto"
                });
            },
            errorCallback: function (error) {
                console.log("entro");
            }
        };
        $.ajaxSimple(params);



        function getMonthName(e){
            var t=[];return t[0]="January",t[1]="February",t[2]="March",t[3]="April",t[4]="May",t[5]="Jun",t[6]="July",t[7]="August",t[8]="September",t[9]="October",t[10]="November",t[11]="December",t[e]
        }
    });

});