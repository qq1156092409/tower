!function($){function d18n(data){if(tower.d18n.permitted()){if(1*simple.util.storage.get("last_d18n_id")===data.late_id)return;simple.util.storage.set("last_d18n_id",data.late_id),tower.d18n.show({title:data.late_notice,content:data.late_content,url:data.late_url,team:tower.team.guid,replaceId:data.late_id})}}function updateUnreadPopover(data){var listEl=$(".noti-pop-list"),emptyEl=$(".noti-pop-empty");if(listEl.length){"ADD"===data.op?(listEl.children("div[data-topic-guid="+data.target_guid+"]").remove(),listEl.prepend(data.late_notice_pop),tower.adjustReadableTime(listEl)):"DEL"===data.op?listEl.children("div[data-topic-guid="+data.target_guid+"]").remove():"CLR"===data.op&&listEl.empty(),0===listEl.children().length?(listEl.hide(),emptyEl.show()):(listEl.show(),emptyEl.hide());var unreadCount=listEl.children().length;tower.updateNoticeCount(unreadCount)}}function ascFn(a,b){var p1=1*$(a).data("sort"),p2=1*$(b).data("sort");return p1-p2}function descFn(a,b){var p1=1*$(a).data("sort"),p2=1*$(b).data("sort");return p2-p1}function memberTodoEvent(todo){var oldEl=$(".boxes").find(".todo.ui-sortable-helper[data-guid="+todo.guid+"]");if(!oldEl.length){if(oldEl=$(".boxes").find(".todo[data-guid="+todo.guid+"]"),"delete"===todo.op)oldEl.remove();else if(/create|update/.test(todo.op)){var memberGuid=$(".workspace .page:last .page-inner").data("guid"),todoEl=$(todo.html),assigneeGuid=todoEl.find(".todo-assign-due .assignee").data("guid");if(assigneeGuid!==memberGuid)return"update"===todo.op&&oldEl.remove(),void tower.renderProjectFilter();oldEl.length?oldEl.replaceWith(todoEl):$(".box-new .todos").append(todoEl),todoEl.closest(".todos-uncompleted").is(".ui-sortable")&&todoEl.closest(".todos-uncompleted").sortable("refresh"),tower.adjustTodo(todoEl)}tower.renderProjectFilter(),todoEl&&todoEl.length&&mcw.highlight(todoEl)}}$(function(){var curMemberId=tower.me.id,channelName="private-member-"+curMemberId,connectionId=$("#conn-guid").val();if("undefined"!=typeof Pusher&&tower.me&&tower.me.guid){var socket=new Pusher("bb025b016f19e1824544289f1246f0b1",{wsHost:"pusher.tower.im",wsPort:8082,wssPort:8082,encrypted:!0,disableFlash:!1,disableStats:!0,enabledTransports:["ws","flash"],activityTimeout:12e4,pongTimeout:3e4}),mychannel=socket.subscribe(channelName);mychannel.bind("client-notify",function(data){"ADD"===data.op&&d18n(data),updateUnreadPopover(data)}),mychannel.bind("event",function(data){var pageEl=$(".workspace .page:last .page-inner");if(pageEl.is("#page-events")){var byMemberGuid=$("#filter-member").val(),eventCreatorGuid=data.event.creator.guid;if(!/[0-9a-z]{32}/.test(byMemberGuid)||eventCreatorGuid===byMemberGuid){var byProjectGuid=$("#filter-project").val(),eventProjectGuid=data.event.ancestor.guid;if(!/[0-9a-z]{32}/.test(byProjectGuid)||eventProjectGuid===byProjectGuid){var $eventEl;try{$eventEl=$($.trim(data.html))}catch(e){$eventEl=null}$("#event-"+$eventEl.attr("id")).length||(tower.initEventList($eventEl,!0),tower.adjustReadableDate($eventEl),tower.adjustEventsDate($eventEl),tower.adjustCreatedAtTime($eventEl),mcw.highlight($eventEl))}}}}),mychannel.bind("comment",function(comment){if(comment.conn_guid!==connectionId){var pageIds={Todo:"page-todo",Document:"page-doc",Message:"page-message",Upload:"page-file",CalendarEvent:"page-calendar-event",Todolist:"page-todolist",Week:"page-member-weekly-report"},pageEl=$(".workspace .page:last .page-inner"),pageId=pageEl.attr("id"),re=new RegExp(comment.commentable.guid);if(pageId===pageIds.Week){if(!re.test(pageEl.data("week-guid")))return}else if(pageId!==pageIds[comment.commentable.type]||!re.test(location.href))return;var commentEl,commentsEl=$(".comments");commentsEl.length&&("create"===comment.op?(commentEl=commentsEl.find("#"+comment.guid),commentEl.length&&commentEl.remove(),commentEl=$(comment.html),commentEl.appendTo(commentsEl),tower.adjustReadableTime(commentEl),tower.hlCode(commentEl)):"delete"===comment.op?commentsEl.find("#"+comment.guid).fadeOut(function(){$(this).remove()}):"update"===comment.op&&(commentEl=$(comment.html),oldCommentEl=commentsEl.find("#"+comment.guid),oldCommentEl.length?oldCommentEl.replaceWith(commentEl):commentEl.appendTo(commentsEl),tower.adjustReadableTime(commentEl),tower.hlCode(commentEl)),commentEl&&commentEl.length&&(tower.initPermission(),mcw.highlight(commentEl)))}}),mychannel.bind("document",function(doc){if(doc.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),re=new RegExp(doc.project_guid);if(pageEl.is("#page-doc")&&new RegExp(doc.guid).test(location.href)&&re.test(location.href)&&!/version/.test(location.href)&&("edit"===doc.op&&tower.me.guid!==doc.current_editor.guid?(pageEl.find(".detail-action-edit-real").addClass("hide"),pageEl.find(".detail-action-edit").removeClass("hide").attr("data-tooltip",doc.current_editor.nickname+" \u6b63\u5728\u7f16\u8f91"),tower.checkEditLock(!0)):"save"===doc.op&&(pageEl.find(".detail-action-edit").addClass("hide"),pageEl.find(".detail-action-edit-real").removeClass("hide"),tower.checkEditLock(!1))),!($.inArray(pageEl.attr("id"),["page-docs","page-project"])<0)&&re.test(location.href)){var docsEl=$(".doc-list");if(docsEl.length){var docEl;if("create"===doc.op)docEl=$(doc.html),docsEl.find("[data-guid="+doc.guid+"]").remove(),docsEl.prepend(docEl),tower.adjustReadableTime(docEl);else if("delete"===doc.op)docsEl.find(".doc[data-guid="+doc.guid+"]").fadeOut(function(){$(this).remove()}),$(".init.init-docs").hide();else if("update"===doc.op){var docEl=$(doc.html);docsEl.find("[data-guid="+doc.guid+"]").remove(),docsEl.prepend(docEl),tower.adjustReadableTime(docEl)}docEl&&docEl.length&&mcw.highlight(docEl)}}}}),mychannel.bind("topic",function(topic){if(topic.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),re=new RegExp(topic.project_guid);if(!($.inArray(pageEl.attr("id"),["page-topics","page-project"])<0)&&re.test(location.href)){var messagesEl=$(".messages");if(messagesEl.length){var moreLink=messagesEl.find(".link-more-topics"),total=moreLink.text().match(/\d+/);total=total?1*total[0]:0;var messageEl;"delete"===topic.op?(messagesEl.find(".message[data-guid="+topic.guid+"]").fadeOut(function(){$(this).remove()}),total--):"create"===topic.op?(messageEl=$(topic.html).hide(),messagesEl.find("[data-guid="+topic.guid+"]").remove(),messagesEl.prepend(messageEl),messagesEl.find(".sticky").prependTo(messagesEl),messageEl.show(),tower.adjustReadableTime(messageEl),$(".init.init-discussion").hide(),total++):"update"===topic.op&&(messageEl=$(topic.html).hide(),messagesEl.find("[data-guid="+topic.guid+"]").remove(),messagesEl.prepend(messageEl),messagesEl.find(".sticky").prependTo(messagesEl),messageEl.show(),tower.adjustReadableTime(messageEl)),pageEl.is("#page-project")&&(messagesEl.find(".message:gt(2)").hide(),messagesEl.find(".message:lt(3)").show()),moreLink.text(moreLink.text().replace(/\d+/,total)),messageEl&&messageEl.length&&mcw.highlight(messageEl)}}}}),mychannel.bind("todo",function(todo){if(todo.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),pageId=pageEl.attr("id");if("page-member"===pageId)return void memberTodoEvent(todo);if($.inArray(pageId,["page-todolists","page-project"])>-1&&new RegExp(todo.project_guid).test(location.href)||"page-todolist"===pageId&&new RegExp(todo.list).test(location.href)){var todoEl,needResort=[];if("create"===todo.op){if(!todo.list)return;todoEl=$(todo.html);var todolistEl=$(".todolist[data-guid="+todo.list+"]"),oldTodoEl=todolistEl.find(".todo[data-guid="+todo.guid+"]"),completed=todoEl.hasClass("completed");oldTodoEl.length&&oldTodoEl.remove(),tower.setTodoFilter(),todolistEl.find(completed?".todos-completed":".todos-uncompleted").append(todoEl),needResort.push(todolistEl[0]),pageEl.trigger("todocreate",[null,null,todoEl,todolistEl]),tower.adjustTodo(todoEl),tower.adjustReadableTime(todoEl),$(".init-todo-empty, .init-todo-completed").remove()}else if("delete"===todo.op)$(".todo[data-guid="+todo.guid+"]").fadeOut(function(){var todoEl=$(this),list=todoEl.closest(".todolist");todoEl.remove(),pageEl.trigger("todoremove",[todoEl,list,null,null])});else if("update"===todo.op){todoEl=$(todo.html);var todolistEl,oldTodoEl=$(".todo[data-guid="+todo.guid+"]"),completed=todoEl.hasClass("completed");if(todolistEl=todo.list?$(".todolist[data-guid="+todo.list+"]"):oldTodoEl.closest(".todolist"),completed?oldTodoEl.fadeOut(function(){todolistEl.find(".todos-completed").prepend(todoEl),oldTodoEl.remove(),pageEl.trigger("todocomplete",[oldTodoEl,todolistEl,todoEl,todolistEl]),tower.adjustReadableTime(todoEl),tower.adjustTodo(todoEl)}):(oldTodoEl.remove(),todolistEl.find(".todos-uncompleted").append(todoEl),pageEl.trigger("todoreopen",[oldTodoEl,todolistEl,todoEl,todolistEl]),tower.adjustReadableTime(todoEl),tower.adjustTodo(todoEl)),tower.setTodoFilter(),!todolistEl.length)return;needResort.push(todolistEl[0])}$.each($.unique(needResort),function(i,todolistEl){var todoWrap=$(todolistEl).find(".todos-uncompleted"),completedWrap=$(todolistEl).find(".todos-completed"),todoEls=todoWrap.children(".todo");completedEls=completedWrap.children(".todo"),todoEls.sort(ascFn),completedEls.sort(ascFn),todoWrap.append(todoEls),completedWrap.append(completedEls)}),todoEl&&todoEl.length&&mcw.highlight(todoEl)}}}),mychannel.bind("todolist",function(todolist){if(todolist.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),re=new RegExp(todolist.project_guid);if(!($.inArray(pageEl.attr("id"),["page-todolists","page-project"])<0)&&re.test(location.href)){var todolistsEl=$(".todolists");if(todolistsEl.length){var needResort=!1;if("create"===todolist.op){var todolistEl=$(todolist.html),oldEl=todolistsEl.find(".todolist[data-guid="+todolist.guid+"]");oldEl.length?oldEl.replaceWith(todolistEl):todolistsEl.prepend(todolistEl),$(".init-todo-empty, .init-todo-completed").remove(),needResort=!0}else if("delete"===todolist.op)todolistsEl.find(".todolist[data-guid="+todolist.guid+"]").fadeOut(function(){$(this).remove()});else if("update"===todolist.op){var todolistEl=todolistsEl.find("[data-guid="+todolist.guid+"]");todolist.name&&(todolistEl.find(".title .desc").remove(),todolistEl.find(".title h4").replaceWith(todolist.name)),todolist.position&&(todolistEl.data("sort",todolist.position),needResort=!0)}if(needResort){var todolistEls=todolistsEl.children(".todolist");todolistEls.sort(descFn),todolistsEl.append(todolistEls)}}}}}),mychannel.bind("file",function(file){if(file.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),re=new RegExp(file.project_guid);if(!($.inArray(pageEl.attr("id"),["page-attachments","page-folder","page-project","page-default-dir"])<0)&&re.test(location.href)){var filesEl=$(".files-view .file-list:first");if(filesEl.length){var fileEl=$(file.html),initEl=$(".init.init-file"),dirGuid=pageEl.data("dir-guid")||0;if("create"===file.op)pageEl.is("#page-default-dir")?(filesEl.prepend(fileEl).closest(".day").show(),initEl.hide(),filesEl.closest(".files-view").show()):file.parent_dir_guid===dirGuid&&(fileEl.prependTo(filesEl),initEl.hide(),filesEl.closest(".files-view").show());else if("delete"===file.op)$(".file[data-guid="+file.guid+"]").fadeOut(function(){filesEl=$(this).closest(".file-list"),$(this).remove(),pageEl.is("#page-default-dir")&&!filesEl.children().length?filesEl.closest(".day").hide():filesEl.children().length||(initEl.show(),filesEl.closest(".files-view").hide())});else if("update"===file.op){var oldFileEl=$(".file[data-guid="+file.guid+"]");file.parent_dir_guid===dirGuid||pageEl.is("#page-default-dir")?oldFileEl.length?oldFileEl.replaceWith(fileEl):filesEl.prepend(fileEl):oldFileEl.fadeOut(function(){$(this).remove(),filesEl.children().length||(initEl.show(),filesEl.closest(".files-view").hide())})}fileEl&&fileEl.length&&mcw.highlight(fileEl),tower.adjustReadableTime(fileEl),$(".page#page-project").length<1&&fileEl.find("a[data-stack]").attr("data-stack-replace","true")}}}}),mychannel.bind("dir",function(dir){if(dir.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner"),re=new RegExp(dir.project_guid);if(!($.inArray(pageEl.attr("id"),["page-attachments","page-folder","page-project"])<0)&&re.test(location.href)){var filesEl=$(".files-view .file-list");if(filesEl.length){var folderEl=$(dir.html),initEl=$(".init.init-file"),dirGuid=pageEl.data("dir-guid")||0;if("create"===dir.op&&dir.parent_dir_guid===dirGuid)folderEl.prependTo(filesEl),initEl.hide(),filesEl.closest(".files-view").show();else if("delete"===dir.op)filesEl.find(".dir[data-guid="+dir.guid+"]").fadeOut(function(){$(this).remove(),filesEl.children().length||(initEl.show(),filesEl.closest(".files-view").hide())});else if("update"===dir.op){var oldFolderEl=filesEl.find(".dir[data-guid="+dir.guid+"]");dir.parent_dir_guid===dirGuid?oldFolderEl.length?oldFolderEl.replaceWith(folderEl):filesEl.prepend(folderEl):oldFolderEl.fadeOut(function(){$(this).remove(),filesEl.children().length||(initEl.show(),filesEl.closest(".files-view").hide())})}folderEl&&folderEl.length&&mcw.highlight(folderEl),$("#page-project").length<1&&folderEl.find("a[data-stack]").attr("data-stack-replace","true"),tower.adjustReadableTime(folderEl)}}}}),mychannel.bind("exporter",function(exporter){if(exporter.conn_guid!==connectionId){var pageEl=$(".workspace .page:last .page-inner");if(pageEl.is("#page-team-settings")){var exportSection=$(".export-section");exportSection.find("p").remove().end().append('<p class="desc completed">\u6570\u636e\u5907\u4efd\u7684\u4e0b\u8f7d\u94fe\u63a5\u5df2\u5728 <span data-readable-time="'+exporter.created_at+'"></span>				\u53d1\u9001\u5230 '+$("#user-email").val()+"\uff0c\u8bf7\u67e5\u6536\u90ae\u4ef6\u540e\u4e0b\u8f7d\u3002"),tower.adjustReadableTime()}}}),mychannel.bind("join_request",function(data){0==data.join_request_count&&$(".system-message.join-request").remove(),data.join_request_count>0&&(0==$(".system-message.join-request").length?$(data.html).prependTo(".wrapper"):($(".system-message.join-request").remove(),$(data.html).prependTo(".wrapper")),$("#page-join-approval").length>0&&$(".system-message.join-request .process-message").attr("data-stack-replace",!0))}),mychannel.bind("project_clone",function(data){var dialog=$(".simple-dialog."+data.guid);dialog.length&&(data.is_template?tower.stack.load(data.project_url,{root:!0}):location.href=data.project_url)})}}),tower.updateNoticeCount=function(count){$.isNumeric(count)&&($("#notification-count").toggleClass("unread",count>0).data("unread-count",count).find(".num").text(count),tower.updatePageTitle(count))}}(jQuery);