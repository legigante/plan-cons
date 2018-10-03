
/**
 * dessine les frises
 * @type {{dndFile: module.exports.dndFile}}
 */
module.exports = {
    init: function () {

        var t = new Date().getTime();

        // based on monday
        function getWeekNumber(d) {
            var d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
            var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
            var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
            return [d.getUTCFullYear(), weekNo];
        }
        function dateDiff(datepart, fromdate, todate) {
            datepart = datepart.toLowerCase();
            var diff = todate.getTime() - fromdate.getTime();
            var divideBy = { w:604800000,
                d:86400000,
                h:3600000,
                n:60000,
                s:1000 };
            return Math.floor( diff/divideBy[datepart]);
        }

        function dateFormat(d){
            var a = d.getDate();
            var b = d.getMonth()+1;
            return (a>9 ? a : '0'+a) + '/' + (b>9 ? b : '0'+b) + '/' + d.getFullYear();
        }
        function getGreenFrise(dateMin, task){
            var r = {};
            var d = new Date(task['date_start']);
            r.start = dateDiff('w',dateMin,d);
            r.end = new Date();
            var arr = [task['date_expected_end'], task['date_end']];
            var i = 0;
            while(i < arr.length){
                if(arr[i] != null){
                    d = new Date(arr[i]);
                    if(d < r.end){
                        r.end = d;
                    }
                }
                i++;
            }
            r.end = dateDiff('w',dateMin,r.end);
            return r;
        }
        function getRedFrise(dateMin, task, iStart){
            var r = {start: iStart};
            r.end = new Date();
            var arr = [task['date_end']];
            var i = 0;
            while(i < arr.length){
                if(arr[i] != null){
                    d = new Date(arr[i]);
                    if(d < r.end){
                        r.end = d;
                    }
                }
                i++;
            }
            r.end = dateDiff('w',dateMin,r.end);
            if(task['date_recallage']!=null){
                r.color = 'green';
            }else{
                r.color = 'red';
            }
            return r;
        }



        var headers = document.getElementById('frise-headers');
        var dateMin, dateMax, weekMax, sClass, d, d1, d2;

        var months = [
            'Janv',
            'Fev',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Sept',
            'Oct',
            'Nov',
            'Dec'
        ];

        if(headers != null) {
            var container = document.getElementById('frise');
            var wait = document.getElementById('frise-loading');
            var jsonheader = JSON.parse(headers.innerHTML);
            dateMin = new Date(jsonheader.min);
            dateMin.setDate(dateMin.getDate()-14);
            dateMax = new Date(jsonheader.max);
            dateMax.setDate(dateMax.getDate()+14);

            weekMax = getWeekNumber(dateMax);
            var iCurrentWeek = dateDiff('w',dateMin,new Date);

            // header
            var html = '<table>';
            var html0 = '<tr>';
            var html1 = '<tr>';
            var html2 = '<tr>';
            var currentDate = new Date(Date.UTC(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate()));
            var currentWeek = getWeekNumber(currentDate);
            var currentMonth = currentDate.getMonth();
            var currentYear = currentDate.getFullYear();
            var iMonth = 0;
            var iYear = 0;
            var matrix = [];
            var i = 0;
            while (currentWeek.join('.') != weekMax.join('.')){

                // date
                d1 = new Date(Date.UTC(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                d2 = new Date(Date.UTC(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                d1.setDate(d1.getDate() - (d1.getDay()-1));
                d2.setDate(d2.getDate() + (7-(d2.getDay())));


                // week + on prépare la patrice pour le contenu
                sClass = '';
                if(iCurrentWeek == i || iCurrentWeek-1 == i){
                    sClass = 'current-week';
                }
                html2 += '<td class="' + sClass  + '" title="' + dateFormat(d1) + '-' + dateFormat(d2) + '">' + currentWeek[1] + '</td>';
                matrix.push('<td class="' + sClass + '"></td>');


                // month
                if(currentMonth==d1.getMonth()){
                    iMonth++;
                }else{
                    html1 += '<td colspan="' + iMonth + '">' + months[currentMonth] + '</td>';
                    currentMonth = d1.getMonth();
                    iMonth = 1;
                }


                // year
                if(currentYear==d1.getFullYear()){
                    iYear++;
                }else{
                    html0 += '<td colspan="' + iYear + '">' + currentYear + '</td>';
                    currentYear = d1.getFullYear();
                    iYear = 1;
                }


                // iteration
                currentDate.setDate(currentDate.getDate()+7);
                currentWeek = getWeekNumber(currentDate);
                i++;
            }
            html0 += '<td colspan="' + iYear + '">' + currentYear + '</td>';
            html1 += '<td colspan="' + iMonth + '">' + months[currentMonth] + '</td>';
            html0 += '</tr>';
            html1 += '</tr>';
            html2 += '</tr>';
            html += html0 + html1 + html2 + '</table>';
            headers.innerHTML = html;

            // content
            var frises = document.getElementsByClassName('frise-data');
            i = 0;
            while(i < frises.length){

                // get data
                var matrix2 = matrix.slice();
                var matrix3 = matrix.slice();
                var json = JSON.parse(frises[i].innerHTML);


                // compute date
                var arr= ['date_rla', 'date_strat', 'date_dpgf', 'date_start', 'date_expected_end', 'date_recallage', 'date_end']
                var j = 0;
                while(j < arr.length){
                    d = new Date(json[arr[j]]);
                    var a = dateDiff('w',dateMin,d);

                    if(arr[j]=='date_end' && json['is_closed'] == true){
                        jsonheader.colors[arr[j]] = jsonheader.colors['is_closed'];
                    }

                    sClass = '';
                    if(a == iCurrentWeek || a == iCurrentWeek-1){
                        sClass = 'current-week';
                    }
                    matrix3[a] = '<td data-prop="' + arr[j] + '" class="jalon ' + sClass + '"><div><span style="background-color: ' + jsonheader.colors[arr[j]] + '" title="' + dateFormat(d) + '"></span></div></td>';
                    j++;
                }
                // compute frise
                if(json['date_start'] != null){
                    // vert
                    var r = getGreenFrise(dateMin,json);
                    j = r.start;
                    while(j <= r.end){
                        sClass = '';
                        if(j == iCurrentWeek || j == iCurrentWeek-1) {
                            sClass = 'current-week';
                        }
                        matrix2[j] = '<td class="' + sClass + '" style="background-color: green;"></td>';
                        j++;
                    }
                    // rouge
                    r = getRedFrise(dateMin, json, r.end);
                    j = r.start;
                    while(j <= r.end){
                        sClass = '';
                        if(j == iCurrentWeek || j == iCurrentWeek-1) {
                            sClass = 'current-week';
                        }
                        matrix2[j] = '<td class="' + sClass + '" style="background-color: ' + r.color + ';"></td>';
                        j++;
                    }
                }




                // display
                html = '<table data-task="' + json.id + '">';
                html += '<tr>' + matrix.join('') + '</td></tr>';
                html += '<tr>' + matrix2.join('') + '</tr>';
                html += '<tr>' + matrix3.join('') + '</tr>';
                html += '</table>';
                frises[i].innerHTML = html;

                i++;
            }

            container.className = '';
            wait.style.display = 'none';

            // events
            var jalons = container.getElementsByClassName('jalon');
            i = 0;
            while(i < jalons.length){
                jalons[i].onclick = function(e){
                    // on cherche data-prop
                    var parent = e.target;
                    while(parent.tagName != 'TD'){
                        var parent = parent.parentNode;
                    }
                    var prop = parent.getAttribute('data-prop');
                    // on cherche data-task
                    while(parent.tagName != 'TABLE'){
                        var parent = parent.parentNode;
                    }
                    var task_id = parent.getAttribute('data-task');

                    // on ajax le form

                    console.log(task_id + '-' + prop);

                };
                i++;
            }


            var tt = new Date().getTime();
            console.log('Frise : ' + Math.round((tt-t))/1000 + 's');

        }
    }
}