$(document).mouseup(function (e) {
    if ($(e.target).closest(".dropdown-container").length === 0 && $(e.target).attr('class') != 'select2-results__option select2-results__option--highlighted') {
        $(".dropdown-container").hide();
    }
    if ($(e.target).closest("#quickCreateIssue").length === 0) {
        $("#quickCreateIssue").hide();
        $('#quickCreateIssueButton').show();
    }
});

var sidebar = $("#sidebar");
var increaseSidebarBtn = $("#sidebar-increase");
var decreaseSidebarBtn = $("#sidebar-decrease");
function setSidebarVisibility() {
    var sidebarToggle   = $("#sidebar-toggle");
    var content         = $("#content");
    if ($(window).width() <= 1024) {
        sidebarToggle.removeClass('hidden');
        decreaseSidebarBtn.addClass('hidden');
        increaseSidebarBtn.removeClass('hidden');
        sidebar.addClass('hidden');
        return content.css('margin-left', '0');
    }
    sidebarToggle.addClass('hidden');
    sidebar.removeClass('hidden');
    content.css('margin-left', '200px');
}
setSidebarVisibility();
$(window).resize(function() {
    setSidebarVisibility();
});
increaseSidebarBtn.on('click', function () {
    sidebar.removeClass('hidden');
    $(this).addClass('hidden');
    decreaseSidebarBtn.removeClass('hidden');
});
decreaseSidebarBtn.on('click', function () {
    sidebar.addClass('hidden');
    $(this).addClass('hidden');
    increaseSidebarBtn.removeClass('hidden');
});