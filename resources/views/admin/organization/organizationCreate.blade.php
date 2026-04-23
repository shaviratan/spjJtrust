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
    <div class="card shadow-sm border-0">
        
        <div class="card-body p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold">Union Structure</h4>

                <button class="btn btn-success px-4" onclick="openModal('Add')">
                    + Add Structure
                </button>
            </div>
            @if($isEmpty)
            <div class="alert alert-warning text-center">
                ⚠️ Data struktur organisasi tidak ditemukan.<br>
                <strong>Berikut adalah contoh struktur organisasi.</strong>
            </div>
            @endif
            <!-- CHART CONTAINER -->
            <div class="bg-light rounded p-3">
                <div id="tree" style="width: 100%; height: 80vh;"></div>
            </div>

        </div>

    </div>
</main>

<div class="modal fade" id="formModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h5 id="modalTitle">Form</h5>
      <input type="hidden" id="nodeId">
      <div class="mb-2">
        <label>Parent (Atasan)</label>
        <select id="parentId" class="form-control" onchange="handleParentChange()">
            <option value="">-- Root (Chairman) --</option>
        </select>
      </div>
      <div class="mb-2">
        <label>Position</label>
        <input type="text" id="title" class="form-control">
        <small id="infoPosition" class="text-muted"></small>
      </div>
      <div class="mb-2">
        <label>Name</label>
        <input type="text" id="name" class="form-control">
      </div>
      <!-- BUTTON -->
      <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" class="btn btn-primary" onclick="saveNode()">
            Save
        </button>
      </div>
    </div>
  </div>
</div>



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

let defaultNodes  = [
    { id: 1, title: "Chairman", name: "Mr.D" },
    { id: 2, pid: 1, tags: ["assistant"], title: "Advisor", name: "Mr. A" },
    { id: 3, pid: 1, tags: ["assistant"], title: "Advisor", name: "Mr.B" },
    { id: 4, pid: 1, tags: ["assistant"], title: "Advisor", name: "Mr. C" },
    { id: 5, pid: 1, title: "Secretary General", name: "Mr. E" },
    { id: 6, pid: 1, title: "Treasurer", name: "Mr. F" },
    { id: 20, pid: 1, title: "Treasurer", name: "Mr. F2" },
    { id: 7, pid: 1, title: "Divisions", name: "Mr." },
    { id: 8, pid: 7, title: "Head of Legal Affairs", name: "Mr. G" },
    { id: 9, pid: 7, title: "Head of Organization", name: "Mr. H" },
    { id: 10, pid: 7, title: "Head of Supervision", name: "Mr. I" },
    { id: 11, pid: 7, title: "Head of Member Relations", name: "J" },
    { id: 12, pid: 7, title: "Head of Membership Administration", name: "Mr. K" },
    { id: 13, pid: 1, title: "Regional Coordinators", name: "Mr." },
    { id: 14, pid: 13, title: "Region I (Jakarta 1)", name: "Mr. L, Mr. M, Mr. N" },
    { id: 15, pid: 13, title: "Region II (Jakarta 2)", name: "Mr. O" },
    { id: 16, pid: 13, title: "Region III (Jakarta 3)", name: "Mr. P" },
    { id: 17, pid: 13, title: "Region IV (Java, Bali & NTT)", name: "Mr. Q" },
    { id: 18, pid: 13, title: "Region V (Sumatra)", name: "Mr. R" },
    { id: 19, pid: 13, title: "Region VI (Kalimantan & Sulawesi)", name: "Mr. S" }
];

let dbNodes = @json($nodes);

let nodes = defaultNodes.map(def => {
    let match = dbNodes.find(d => d.title === def.title);

    if (match) {
        return {
            ...def,
            name: match.name
        };
    }

    return def;
});

var chart = new OrgChart(document.getElementById("tree"), {
    template: "ana",

    layout: OrgChart.mixed,
    scaleInitial: OrgChart.match.boundary,

    enableSearch: false,
    mouseScrool: OrgChart.action.none,
    enableZoom: false,

    nodeMenu: {
        details: { text: "View" },
        edit: { text: "Edit" },
        remove: { text: "Delete" }
    },

    nodeBinding: {
        field_0: "title",
        field_1: "name"
    },

    nodes: nodes
});


    chart.on('edit', function(sender, node){
        openModal("Edit", node.id, node.pid, node);
        return false;
    });

    chart.on('remove', function(sender, node){
        if(confirm("Yakin hapus?")){
            chart.remove(node.id);
        }
        return false;
    });

function openModal(type, id = null, parentId = null, data = null){
    document.getElementById("modalTitle").innerText = type + " Node";
    document.getElementById("nodeId").value = id || "";

    loadParentOptions();

    // set parent dropdown
    document.getElementById("parentId").value = parentId || "";

    if(data){
        // MODE EDIT
        document.getElementById("title").value = data.title;
        document.getElementById("name").value = data.name;
        document.getElementById("infoCount").innerText = "";
    } else {
        // MODE ADD
        let parentNode = chart.get(parentId);

        if(parentNode){
            let parentTitle = parentNode.title;

            // hitung jumlah node dengan jabatan sama
            let count = chart.config.nodes.filter(n => n.title === parentTitle).length;

            // AUTO ISI
            document.getElementById("title").value = parentTitle;
            document.getElementById("name").value = parentTitle + " ke-" + (count + 1);

            //INFO JUMLAH
            document.getElementById("infoCount").innerText =
                "Saat ini jumlah " + parentTitle + " ada " + count;
        }
    }

    var modal = new bootstrap.Modal(document.getElementById('formModal'));
    modal.show();
}

function saveNode(){
     let id = document.getElementById("nodeId").value;
    let parentTitle = document.getElementById("parentId").value;
    let title = document.getElementById("title").value;
    let name = document.getElementById("name").value;

    let parentNode = chart.config.nodes.find(n => n.title === parentTitle);
    let parentId = parentNode ? parentNode.id : null;

    fetch("{{ route('organization.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            title: title,
            name: name,
            parent_id: parentId
        })
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){

            // ✅ ALERT SUCCESS
            alert("✅ " + res.message);
            chart.add({
                id: Date.now(),
                pid: parentId,
                title: title,
                name: name
            });

            bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();

        } else {
            alert("❌ " + res.message);
        }
    })
    .catch(err => {
        // ERROR SERVER
        alert("❌ Terjadi kesalahan server!");
        console.error(err);
    });
}

function closeModal(){
    let modal = bootstrap.Modal.getInstance(document.getElementById('formModal'));
    modal.hide();
}

function loadParentOptions(selectedTitle = null){
    let select = document.getElementById("parentId");
    select.innerHTML = '<option value="">-- Root (Chairman) --</option>';
    let uniqueTitles = [];
    chart.config.nodes.forEach(node => {
        if(!uniqueTitles.includes(node.title)){
            uniqueTitles.push(node.title);
            let option = document.createElement("option");
            option.value = node.title; // 🔥 pakai title
            option.text = node.title;
            if(selectedTitle && node.title === selectedTitle){
                option.selected = true;
            }
            select.appendChild(option);
        }
    });
}
function handleParentChange(){
    let parentTitle = document.getElementById("parentId").value;
    let info = document.getElementById("infoPosition");
    if(!parentTitle){
        info.innerText = "";
        document.getElementById("title").value = "";
        return;
    }
    info.innerText = "Loading...";
    fetch(`/organization/count?title=${parentTitle}`, {
        headers: {
            'ngrok-skip-browser-warning': '1'
        }
    })
    .then(res => res.json())
    .then(res => {
        //kalau DB kosong → count = 0
        let count = res.count ?? 0;
        info.innerText = `Saat ini ${parentTitle} ada ${count}`;
        // AUTO POSITION
        document.getElementById("title").value =
            parentTitle + " ke-" + (count + 1);
    })
    .catch(err => {
        console.error(err);
        //fallback kalau API gagal
        info.innerText = `Saat ini ${parentTitle} ada 0`;
        document.getElementById("title").value =
            parentTitle + " ke-1";
    });
}
</script>

</body>
</html>