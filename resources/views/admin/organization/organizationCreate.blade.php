<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')

<style>
    #tree {
        width: 100%;
        height: 100vh;
    }
</style>

<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="card-body p-4">
        <div class="container mt-5">
            <h3 class="text-center mb-5">Union Structure</h3>
            <div id="tree"></div>
        </div>
    </div>
</main>

@include('components.script')

<!-- ORGCHART JS -->
<script src="https://balkan.app/js/OrgChart.js"></script>

<script>
OrgChart.templates.ana.defs = `
<linearGradient id="blueGradient" x1="0" x2="0" y1="0" y2="1">
    <stop offset="0%" stop-color="#42A5F5"/>
    <stop offset="100%" stop-color="#1E88E5"/>
</linearGradient>
`;

OrgChart.templates.ana.size = [300, 140];

OrgChart.templates.ana.node = function(node){
    return `<rect x="0" y="0" height="${node.h}" width="${node.w}"
            fill="url(#blueGradient)" stroke-width="1" stroke="#aeaeae" rx="15" ry="15"></rect>`;
};

OrgChart.templates.ana.field_0 = function(node, data, template, config, value){
    return OrgChart.wrapText(value, 
        `<text style="font-size: 20px; font-weight:bold;" fill="#ffffff" 
        x="${node.w / 2}" y="${node.h -30}" text-anchor="middle"></text>`, 
        node.w - 40, 2);
};

OrgChart.templates.ana.field_1 = function(node, data, template, config, value){
    return OrgChart.wrapText(value, 
        `<text style="font-size: 15px;" fill="#ffffff" 
        x="${node.w / 2}" y="40" text-anchor="middle"></text>`, 
        node.w - 40, 2);
};


var chart = new OrgChart(document.getElementById("tree"), {
    template: "ana",

    // 🔥 BIAR RAPI & GAK MELEBAR
    layout: OrgChart.mixed,

    // 🔥 AUTO FIT TANPA GESER
    scaleInitial: OrgChart.match.boundary,

    enableSearch: false,
    mouseScrool: OrgChart.action.none,
    enableZoom: false,

    nodeBinding: {
        field_0: "title",
        field_1: "name"
    },

    nodes: [
        { id: 1, title: "Chairman", name: "D" },
        { id: 2, pid: 1, tags: ["assistant"], title: "Advisor", name: "A" },
        { id: 3, pid: 1, tags: ["assistant"], title: "Advisor", name: "B" },
        { id: 4, pid: 1, tags: ["assistant"], title: "Advisor", name: "C" },
        { id: 5, pid: 1, title: "Secretary General", name: "E" },
        { id: 6, pid: 1, title: "Treasurer", name: "F" },
        { id: 20, pid: 1, title: "Treasurer", name: "F2" },
        { id: 7, pid: 1, title: "Divisions", name: "" },
        { id: 8, pid: 7, title: "Head of Legal Affairs", name: "G" },
        { id: 9, pid: 7, title: "Head of Organization", name: "H" },
        { id: 10, pid: 7, title: "Head of Supervision", name: "I" },
        { id: 11, pid: 7, title: "Head of Member Relations", name: "J" },
        { id: 12, pid: 7, title: "Head of Membership Administration", name: "K" },
        { id: 13, pid: 1, title: "Regional Coordinators", name: "" },
        { id: 14, pid: 13, title: "Region I (Jakarta 1)", name: "L, M, N" },
        { id: 15, pid: 13, title: "Region II (Jakarta 2)", name: "O" },
        { id: 16, pid: 13, title: "Region III (Jakarta 3)", name: "P" },
        { id: 17, pid: 13, title: "Region IV (Java, Bali & NTT)", name: "Q" },
        { id: 18, pid: 13, title: "Region V (Sumatra)", name: "R" },
        { id: 19, pid: 13, title: "Region VI (Kalimantan & Sulawesi)", name: "S" }
    ]
});
</script>

</body>
</html>