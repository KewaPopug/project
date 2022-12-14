// let cabinets = {
//     1: ["101", "102"],
//     2: ["201", "202"],
//     3: ["301", "302"],
// };

let cabinets = $('.cabinet').data('rows-count') ;

console.log(cabinets)

let corps = document.getElementById("corps");
let cabinet = document.getElementById("cabinet");
window.onload = selectCorps;
corps.onchange = selectCorps;

function selectCorps(ev) {
    cabinet.innerHTML = "";
    let c = this.value || "1", o;
    for (let i = 0; cabinets[c].length; i++) {
        o = new Option(cabinets[c][i], i, false, false);
        cabinet.add(o);
        break;
    }
}

