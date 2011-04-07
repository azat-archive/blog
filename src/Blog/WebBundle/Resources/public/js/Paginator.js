/**
 * @author Azat Khizhin
 * 
 * Paginator hotkeys
 */

Paginator = function() {}
Paginator.prototype.init = function() {
	if ($('div.pagination').length === 0) {
		return false;
	}
	this.currentPage = this.getCurrentPage();
	this.bind();
}
Paginator.prototype.getCurrentPage = function() {
	var matches = document.location.pathname.match(/page\/(\d+)(?:\/|$)/);
	return (matches ? parseInt(matches[1]) : 1);
}
Paginator.prototype.haveAction = function() {
	var parts = document.location.pathname.split('/');
	return (parts.length > 1);
}
Paginator.prototype.goToPage = function(page) {
	if (page < 1) {
		return false;
	}
	var location = document.location.pathname;
	if (!this.haveAction()) {
		location += (location.substr(-1) != '/' ? '/' : '');
	}
	if (!document.location.pathname.match(/page\/(\d+)(?:\/|$)/)) {
		location += (location.substr(-1) != '/' ? '/' : '') + 'page/' + page;
	} else {
		location = location.replace('page/' + this.currentPage, 'page/' + page);
	}
	document.location = location;
}
Paginator.prototype.bind = function() {
	if ($('div.pagination span.previous').length !== 0) {
		$(document).bind('keydown', 'ctrl+left', $.proxy(function (event) {
			this.goToPage(this.currentPage-1);
			return false;
		}, this));
	}
	
	if ($('div.pagination span.next').length !== 0) {
		$(document).bind('keydown', 'ctrl+right', $.proxy(function (event) {
			this.goToPage(this.currentPage+1);
			return false;
		}, this));
	}
}
