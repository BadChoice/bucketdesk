let availablePaths = {
    "go" : "/thrust/issues",
    "gc" : "/thrust/cycles",
    "gb" : "/issues/backlog",
    "gx" : "/calendar",
    "gt" : "/trello",

    "fo" : "thrust/issues/open",
    "fh" : "thrust/issues/hold",
    "fn" : "thrust/issues/new",
};
let currentPath = "";

document.onkeyup = function(e) {
    if (! e.ctrlKey && document.activeElement !== document.body) return;
    currentPath = currentPath + e.key;

    $.each(availablePaths, function(index, value){
        if (index == currentPath) { goToPath(value) }
    });
};

function goToPath(path){
    console.log("Going to " + path);
    currentPath = "";
    window.location = path
}
