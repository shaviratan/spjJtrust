<!DOCTYPE html>
<html lang="en">
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

            <div class="d-flex justify-content-between mb-3">
                <h4>Union Structure</h4>
                <button class="btn btn-success" onclick="openModal()">+ Add</button>
            </div>

            @if($isEmpty)
            <div class="alert alert-warning text-center">
                Data kosong, menggunakan struktur default
            </div>
            @endif

            <div id="tree"></div>

        </div>
    </div>
</main>

<!-- MODAL -->
<div class="modal fade" id="formModal">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h5>Form</h5>

      <input type="hidden" id="nodeId">

      <div class="mb-2">
        <label>Parent</label>
        <select id="parentId" class="form-control"></select>
      </div>

      <div class="mb-2">
        <label>Position</label>
        <input type="text" id="title" class="form-control">
      </div>

      <div class="mb-2">
        <label>Name</label>
        <input type="text" id="name" class="form-control">
      </div>

      <div class="text-end mt-3">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveNode()">Save</button>
      </div>
    </div>
  </div>
</div>

@include('components.script')

<script src="https://balkan.app/js/OrgChart.js"></script>

<script>

// ================= DEFAULT STRUCTURE =================
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
console.log("DEFAULT:", defaultNodes);
// ================= DB DATA =================
let dbNodes = @json($nodes);
console.log("DB NODES:", dbNodes);
// ================= MERGE =================
let nodes = (defaultNodes || []).map(def => {

    let match = dbNodes.find(d =>
        d.title.replace(/\s+ke-\d+/, '') === def.title
    );

    if(match){
        return {
            ...def,
            name: match.name + " (ke-" + (match.order || 1) + ")"
        };
    }

    return def;
});
// ================= CHART =================
let chart = new OrgChart(document.getElementById("tree"), {
    template: "ana",
    nodeBinding: {
        field_0: "title",
        field_1: "name"
    },
    nodes: nodes,
    nodeMenu: {
        edit: { text: "Edit" },
        remove: { text: "Delete" }
    }
});

// ================= LOAD PARENT =================
function loadParentOptions(selectedId=null){
    let select = document.getElementById("parentId");
    select.innerHTML = '<option value="">-- Root --</option>';

    chart.config.nodes.forEach(node => {
        let option = document.createElement("option");
        option.value = node.id;
        option.text = node.title;

        if(selectedId && node.id == selectedId){
            option.selected = true;
        }

        select.appendChild(option);
    });
}

// ================= MODAL =================
function openModal(){
    document.getElementById("title").value = "";
    document.getElementById("name").value = "";
    loadParentOptions();

    new bootstrap.Modal(document.getElementById('formModal')).show();
}

// ================= SAVE =================
function saveNode(){

    let parentId = document.getElementById("parentId").value || null;
    let title = document.getElementById("title").value;
    let name = document.getElementById("name").value;

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
            alert("✅ berhasil");

            location.reload(); // reload biar merge ulang
        } else {
            alert("❌ gagal");
        }
    });
}

// ================= DELETE =================
function deleteNode(id){
    fetch(`/organization/delete/${id}`)
    .then(() => {
        alert("✅ dihapus");
        location.reload();
    });
}

</script>

</body>
</html>