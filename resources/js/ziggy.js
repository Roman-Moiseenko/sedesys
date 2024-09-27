const Ziggy = {
    "url": "http:\/\/localhost", "port": null, "defaults": {}, "routes": {
        "debugbar.openhandler": {"uri": "_debugbar\/open", "methods": ["GET", "HEAD"]},
        "debugbar.clockwork": {"uri": "_debugbar\/clockwork\/{id}", "methods": ["GET", "HEAD"], "parameters": ["id"]},
        "debugbar.assets.css": {"uri": "_debugbar\/assets\/stylesheets", "methods": ["GET", "HEAD"]},
        "debugbar.assets.js": {"uri": "_debugbar\/assets\/javascript", "methods": ["GET", "HEAD"]},
        "debugbar.cache.delete": {
            "uri": "_debugbar\/cache\/{key}\/{tags?}",
            "methods": ["DELETE"],
            "parameters": ["key", "tags"]
        },
        "sanctum.csrf-cookie": {"uri": "sanctum\/csrf-cookie", "methods": ["GET", "HEAD"]},
        "ignition.healthCheck": {"uri": "_ignition\/health-check", "methods": ["GET", "HEAD"]},
        "ignition.executeSolution": {"uri": "_ignition\/execute-solution", "methods": ["POST"]},
        "ignition.updateConfig": {"uri": "_ignition\/update-config", "methods": ["POST"]},
        "admin.logout": {
            "uri": "admin\/logout",
            "methods": ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"]
        },
        "admin.staff.password": {
            "uri": "admin\/staff\/{staff}\/password",
            "methods": ["POST"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.toggle": {
            "uri": "admin\/staff\/{staff}\/toggle",
            "methods": ["POST"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.responsibility": {
            "uri": "admin\/staff\/{staff}\/responsibility",
            "methods": ["POST"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.index": {"uri": "admin\/staff", "methods": ["GET", "HEAD"]},
        "admin.staff.create": {"uri": "admin\/staff\/create", "methods": ["GET", "HEAD"]},
        "admin.staff.store": {"uri": "admin\/staff", "methods": ["POST"]},
        "admin.staff.show": {
            "uri": "admin\/staff\/{staff}",
            "methods": ["GET", "HEAD"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.edit": {
            "uri": "admin\/staff\/{staff}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.update": {
            "uri": "admin\/staff\/{staff}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.staff.destroy": {
            "uri": "admin\/staff\/{staff}",
            "methods": ["DELETE"],
            "parameters": ["staff"],
            "bindings": {"staff": "id"}
        },
        "admin.home": {"uri": "admin", "methods": ["GET", "HEAD"]},
        "admin.calendar.rule.toggle": {
            "uri": "admin\/calendar\/rule\/{rule}\/toggle",
            "methods": ["POST"],
            "parameters": ["rule"],
            "bindings": {"rule": "id"}
        },
        "admin.calendar.calendar.create": {
            "uri": "admin\/calendar\/calendar\/create",
            "methods": ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"]
        },
        "admin.calendar.calendar.to-order": {
            "uri": "admin\/calendar\/calendar\/{calendar}\/to-order",
            "methods": ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
            "parameters": ["calendar"],
            "bindings": {"calendar": "id"}
        },
        "admin.calendar.calendar.cancel": {
            "uri": "admin\/calendar\/calendar\/{calendar}\/cancel",
            "methods": ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
            "parameters": ["calendar"],
            "bindings": {"calendar": "id"}
        },
        "admin.calendar.calendar.destroy": {
            "uri": "admin\/calendar\/calendar\/destroy\/{calendar}",
            "methods": ["DELETE"],
            "parameters": ["calendar"],
            "bindings": {"calendar": "id"}
        },
        "admin.calendar.calendar.index": {"uri": "admin\/calendar\/calendar", "methods": ["GET", "HEAD"]},
        "admin.calendar.rule.index": {"uri": "admin\/calendar\/rule", "methods": ["GET", "HEAD"]},
        "admin.calendar.rule.create": {"uri": "admin\/calendar\/rule\/create", "methods": ["GET", "HEAD"]},
        "admin.calendar.rule.store": {"uri": "admin\/calendar\/rule", "methods": ["POST"]},
        "admin.calendar.rule.show": {
            "uri": "admin\/calendar\/rule\/{rule}",
            "methods": ["GET", "HEAD"],
            "parameters": ["rule"],
            "bindings": {"rule": "id"}
        },
        "admin.calendar.rule.edit": {
            "uri": "admin\/calendar\/rule\/{rule}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["rule"],
            "bindings": {"rule": "id"}
        },
        "admin.calendar.rule.update": {
            "uri": "admin\/calendar\/rule\/{rule}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["rule"],
            "bindings": {"rule": "id"}
        },
        "admin.calendar.rule.destroy": {
            "uri": "admin\/calendar\/rule\/{rule}",
            "methods": ["DELETE"],
            "parameters": ["rule"],
            "bindings": {"rule": "id"}
        },
        "admin.discount.promotion.toggle": {
            "uri": "admin\/discount\/promotion\/{promotion}\/toggle",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.start": {
            "uri": "admin\/discount\/promotion\/{promotion}\/start",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.finish": {
            "uri": "admin\/discount\/promotion\/{promotion}\/finish",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.attach": {
            "uri": "admin\/discount\/promotion\/{promotion}\/attach",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.detach": {
            "uri": "admin\/discount\/promotion\/{promotion}\/detach",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.set": {
            "uri": "admin\/discount\/promotion\/{promotion}\/set",
            "methods": ["POST"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.index": {"uri": "admin\/discount\/promotion", "methods": ["GET", "HEAD"]},
        "admin.discount.promotion.create": {"uri": "admin\/discount\/promotion\/create", "methods": ["GET", "HEAD"]},
        "admin.discount.promotion.store": {"uri": "admin\/discount\/promotion", "methods": ["POST"]},
        "admin.discount.promotion.show": {
            "uri": "admin\/discount\/promotion\/{promotion}",
            "methods": ["GET", "HEAD"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.edit": {
            "uri": "admin\/discount\/promotion\/{promotion}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.update": {
            "uri": "admin\/discount\/promotion\/{promotion}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.promotion.destroy": {
            "uri": "admin\/discount\/promotion\/{promotion}",
            "methods": ["DELETE"],
            "parameters": ["promotion"],
            "bindings": {"promotion": "id"}
        },
        "admin.discount.coupon.index": {"uri": "admin\/discount\/coupon", "methods": ["GET", "HEAD"]},
        "admin.discount.coupon.create": {"uri": "admin\/discount\/coupon\/create", "methods": ["GET", "HEAD"]},
        "admin.discount.coupon.store": {"uri": "admin\/discount\/coupon", "methods": ["POST"]},
        "admin.discount.coupon.show": {
            "uri": "admin\/discount\/coupon\/{coupon}",
            "methods": ["GET", "HEAD"],
            "parameters": ["coupon"],
            "bindings": {"coupon": "id"}
        },
        "admin.discount.coupon.destroy": {
            "uri": "admin\/discount\/coupon\/{coupon}",
            "methods": ["DELETE"],
            "parameters": ["coupon"],
            "bindings": {"coupon": "id"}
        },
        "admin.employee.employee.index": {"uri": "admin\/employee\/employee", "methods": ["GET", "HEAD"]},
        "admin.employee.employee.create": {"uri": "admin\/employee\/employee\/create", "methods": ["GET", "HEAD"]},
        "admin.employee.employee.store": {"uri": "admin\/employee\/employee", "methods": ["POST"]},
        "admin.employee.employee.show": {
            "uri": "admin\/employee\/employee\/{employee}",
            "methods": ["GET", "HEAD"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.employee.edit": {
            "uri": "admin\/employee\/employee\/{employee}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.employee.update": {
            "uri": "admin\/employee\/employee\/{employee}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.employee.destroy": {
            "uri": "admin\/employee\/employee\/{employee}",
            "methods": ["DELETE"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.specialization.index": {"uri": "admin\/employee\/specialization", "methods": ["GET", "HEAD"]},
        "admin.employee.specialization.create": {
            "uri": "admin\/employee\/specialization\/create",
            "methods": ["GET", "HEAD"]
        },
        "admin.employee.specialization.store": {"uri": "admin\/employee\/specialization", "methods": ["POST"]},
        "admin.employee.specialization.show": {
            "uri": "admin\/employee\/specialization\/{specialization}",
            "methods": ["GET", "HEAD"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.edit": {
            "uri": "admin\/employee\/specialization\/{specialization}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.update": {
            "uri": "admin\/employee\/specialization\/{specialization}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.destroy": {
            "uri": "admin\/employee\/specialization\/{specialization}",
            "methods": ["DELETE"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.employee.toggle": {
            "uri": "admin\/employee\/employee\/{employee}\/toggle",
            "methods": ["POST"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.employee.attach-service": {
            "uri": "admin\/employee\/employee\/{employee}\/attach-service",
            "methods": ["POST"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.employee.detach-service": {
            "uri": "admin\/employee\/employee\/{employee}\/detach-service",
            "methods": ["POST"],
            "parameters": ["employee"],
            "bindings": {"employee": "id"}
        },
        "admin.employee.specialization.toggle": {
            "uri": "admin\/employee\/specialization\/{specialization}\/toggle",
            "methods": ["POST"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.attach": {
            "uri": "admin\/employee\/specialization\/{specialization}\/attach",
            "methods": ["POST"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.up": {
            "uri": "admin\/employee\/specialization\/{specialization}\/up",
            "methods": ["POST"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.down": {
            "uri": "admin\/employee\/specialization\/{specialization}\/down",
            "methods": ["POST"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.employee.specialization.detach": {
            "uri": "admin\/employee\/specialization\/{specialization}\/detach",
            "methods": ["POST"],
            "parameters": ["specialization"],
            "bindings": {"specialization": "id"}
        },
        "admin.feedback.template.toggle": {
            "uri": "admin\/feedback\/template\/{template}\/toggle",
            "methods": ["POST"],
            "parameters": ["template"],
            "bindings": {"template": "id"}
        },
        "admin.feedback.feedback.dashboard": {
            "uri": "admin\/feedback\/feedback\/dashboard",
            "methods": ["GET", "HEAD"]
        },
        "admin.feedback.feedback.to-email": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/to-email",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.to-order": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/to-order",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.to-completed": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/to-completed",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.to-archive": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/to-archive",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.from-archive": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/from-archive",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.set-staff": {
            "uri": "admin\/feedback\/feedback\/{feedback}\/set-staff",
            "methods": ["POST"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.feedback.index": {"uri": "admin\/feedback\/feedback", "methods": ["GET", "HEAD"]},
        "admin.feedback.feedback.show": {
            "uri": "admin\/feedback\/feedback\/{feedback}",
            "methods": ["GET", "HEAD"],
            "parameters": ["feedback"],
            "bindings": {"feedback": "id"}
        },
        "admin.feedback.template.index": {"uri": "admin\/feedback\/template", "methods": ["GET", "HEAD"]},
        "admin.feedback.template.create": {"uri": "admin\/feedback\/template\/create", "methods": ["GET", "HEAD"]},
        "admin.feedback.template.store": {"uri": "admin\/feedback\/template", "methods": ["POST"]},
        "admin.feedback.template.show": {
            "uri": "admin\/feedback\/template\/{template}",
            "methods": ["GET", "HEAD"],
            "parameters": ["template"],
            "bindings": {"template": "id"}
        },
        "admin.feedback.template.edit": {
            "uri": "admin\/feedback\/template\/{template}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["template"],
            "bindings": {"template": "id"}
        },
        "admin.feedback.template.update": {
            "uri": "admin\/feedback\/template\/{template}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["template"],
            "bindings": {"template": "id"}
        },
        "admin.feedback.template.destroy": {
            "uri": "admin\/feedback\/template\/{template}",
            "methods": ["DELETE"],
            "parameters": ["template"],
            "bindings": {"template": "id"}
        },
        "admin.mail.system.attachment": {"uri": "admin\/mail\/system\/attachment", "methods": ["GET", "HEAD"]},
        "admin.mail.system.repeat": {
            "uri": "admin\/mail\/system\/repeat\/{system}",
            "methods": ["POST"],
            "parameters": ["system"],
            "bindings": {"system": "id"}
        },
        "admin.mail.outbox.attachment": {"uri": "admin\/mail\/outbox\/attachment", "methods": ["GET", "HEAD"]},
        "admin.mail.outbox.repeat": {
            "uri": "admin\/mail\/outbox\/repeat\/{outbox}",
            "methods": ["POST"],
            "parameters": ["outbox"]
        },
        "admin.mail.outbox.send": {
            "uri": "admin\/mail\/outbox\/send\/{outbox}",
            "methods": ["POST"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.mail.outbox.delete-attachment": {
            "uri": "admin\/mail\/outbox\/delete-attachment\/{outbox}",
            "methods": ["POST"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.mail.inbox.attachment": {"uri": "admin\/mail\/inbox\/attachment", "methods": ["GET", "HEAD"]},
        "admin.mail.inbox.reply": {
            "uri": "admin\/mail\/inbox\/reply\/{inbox}",
            "methods": ["GET", "HEAD"],
            "parameters": ["inbox"],
            "bindings": {"inbox": "id"}
        },
        "admin.mail.inbox.load": {"uri": "admin\/mail\/inbox\/load", "methods": ["GET", "HEAD"]},
        "admin.mail.system.index": {"uri": "admin\/mail\/system", "methods": ["GET", "HEAD"]},
        "admin.mail.system.show": {
            "uri": "admin\/mail\/system\/{system}",
            "methods": ["GET", "HEAD"],
            "parameters": ["system"],
            "bindings": {"system": "id"}
        },
        "admin.mail.inbox.index": {"uri": "admin\/mail\/inbox", "methods": ["GET", "HEAD"]},
        "admin.mail.inbox.show": {
            "uri": "admin\/mail\/inbox\/{inbox}",
            "methods": ["GET", "HEAD"],
            "parameters": ["inbox"],
            "bindings": {"inbox": "id"}
        },
        "admin.mail.inbox.destroy": {
            "uri": "admin\/mail\/inbox\/{inbox}",
            "methods": ["DELETE"],
            "parameters": ["inbox"],
            "bindings": {"inbox": "id"}
        },
        "admin.mail.outbox.index": {"uri": "admin\/mail\/outbox", "methods": ["GET", "HEAD"]},
        "admin.mail.outbox.create": {"uri": "admin\/mail\/outbox\/create", "methods": ["GET", "HEAD"]},
        "admin.mail.outbox.store": {"uri": "admin\/mail\/outbox", "methods": ["POST"]},
        "admin.mail.outbox.show": {
            "uri": "admin\/mail\/outbox\/{outbox}",
            "methods": ["GET", "HEAD"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.mail.outbox.edit": {
            "uri": "admin\/mail\/outbox\/{outbox}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.mail.outbox.update": {
            "uri": "admin\/mail\/outbox\/{outbox}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.mail.outbox.destroy": {
            "uri": "admin\/mail\/outbox\/{outbox}",
            "methods": ["DELETE"],
            "parameters": ["outbox"],
            "bindings": {"outbox": "id"}
        },
        "admin.notification.notification.read": {
            "uri": "admin\/notification\/notification\/read\/{notification}",
            "methods": ["POST"],
            "parameters": ["notification"],
            "bindings": {"notification": "id"}
        },
        "admin.notification.telegram.chat-id": {"uri": "admin\/notification\/telegram\/chat-id", "methods": ["POST"]},
        "admin.notification.notification.index": {
            "uri": "admin\/notification\/notification",
            "methods": ["GET", "HEAD"]
        },
        "admin.notification.notification.create": {
            "uri": "admin\/notification\/notification\/create",
            "methods": ["GET", "HEAD"]
        },
        "admin.notification.notification.store": {"uri": "admin\/notification\/notification", "methods": ["POST"]},
        "admin.order.order.create-staff": {"uri": "admin\/order\/order\/create-staff", "methods": ["POST"]},
        "admin.order.order.add-item": {
            "uri": "admin\/order\/order\/{order}\/add-item",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.del-item": {
            "uri": "admin\/order\/order\/{order}\/del-item",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.set-item": {
            "uri": "admin\/order\/order\/{order}\/set-item",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.set-user": {
            "uri": "admin\/order\/order\/{order}\/set-user",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.awaiting": {
            "uri": "admin\/order\/order\/{order}\/awaiting",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.cancel": {
            "uri": "admin\/order\/order\/{order}\/cancel",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.paid": {
            "uri": "admin\/order\/order\/{order}\/paid",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.cheque": {
            "uri": "admin\/order\/order\/{order}\/cheque",
            "methods": ["POST"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.index": {"uri": "admin\/order\/order", "methods": ["GET", "HEAD"]},
        "admin.order.order.create": {"uri": "admin\/order\/order\/create", "methods": ["GET", "HEAD"]},
        "admin.order.order.store": {"uri": "admin\/order\/order", "methods": ["POST"]},
        "admin.order.order.show": {
            "uri": "admin\/order\/order\/{order}",
            "methods": ["GET", "HEAD"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.order.edit": {
            "uri": "admin\/order\/order\/{order}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["order"]
        },
        "admin.order.order.update": {
            "uri": "admin\/order\/order\/{order}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["order"]
        },
        "admin.order.order.destroy": {
            "uri": "admin\/order\/order\/{order}",
            "methods": ["DELETE"],
            "parameters": ["order"],
            "bindings": {"order": "id"}
        },
        "admin.order.payment.index": {"uri": "admin\/order\/payment", "methods": ["GET", "HEAD"]},
        "admin.order.payment.create": {"uri": "admin\/order\/payment\/create", "methods": ["GET", "HEAD"]},
        "admin.order.payment.store": {"uri": "admin\/order\/payment", "methods": ["POST"]},
        "admin.order.payment.show": {
            "uri": "admin\/order\/payment\/{payment}",
            "methods": ["GET", "HEAD"],
            "parameters": ["payment"]
        },
        "admin.order.payment.edit": {
            "uri": "admin\/order\/payment\/{payment}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["payment"]
        },
        "admin.order.payment.update": {
            "uri": "admin\/order\/payment\/{payment}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["payment"]
        },
        "admin.order.payment.destroy": {
            "uri": "admin\/order\/payment\/{payment}",
            "methods": ["DELETE"],
            "parameters": ["payment"]
        },
        "admin.page.page.toggle": {
            "uri": "admin\/page\/page\/{page}\/toggle",
            "methods": ["POST"],
            "parameters": ["page"],
            "bindings": {"page": "id"}
        },
        "admin.page.widget.toggle": {
            "uri": "admin\/page\/widget\/{widget}\/toggle",
            "methods": ["POST"],
            "parameters": ["widget"]
        },
        "admin.page.contact.toggle": {
            "uri": "admin\/page\/contact\/{contact}\/toggle",
            "methods": ["POST"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.contact.up": {
            "uri": "admin\/page\/contact\/{contact}\/up",
            "methods": ["POST"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.contact.down": {
            "uri": "admin\/page\/contact\/{contact}\/down",
            "methods": ["POST"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.gallery.add": {
            "uri": "admin\/page\/gallery\/{gallery}\/add",
            "methods": ["POST"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.del": {
            "uri": "admin\/page\/gallery\/{gallery}\/del",
            "methods": ["POST"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.set": {
            "uri": "admin\/page\/gallery\/{gallery}\/set",
            "methods": ["POST"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.get-tree": {"uri": "admin\/page\/gallery\/get-tree", "methods": ["POST"]},
        "admin.page.gallery.get-photo": {"uri": "admin\/page\/gallery\/get-photo", "methods": ["POST"]},
        "admin.page.template.index": {"uri": "admin\/page\/template", "methods": ["GET", "HEAD"]},
        "admin.page.template.show": {
            "uri": "admin\/page\/template\/{type}\/{template}",
            "methods": ["GET", "HEAD"],
            "parameters": ["type", "template"]
        },
        "admin.page.template.store": {"uri": "admin\/page\/template", "methods": ["POST"]},
        "admin.page.template.update": {"uri": "admin\/page\/template", "methods": ["PUT"]},
        "admin.page.template.destroy": {
            "uri": "admin\/page\/template\/{type}\/{template}",
            "methods": ["DELETE"],
            "parameters": ["type", "template"]
        },
        "admin.page.page.index": {"uri": "admin\/page\/page", "methods": ["GET", "HEAD"]},
        "admin.page.page.create": {"uri": "admin\/page\/page\/create", "methods": ["GET", "HEAD"]},
        "admin.page.page.store": {"uri": "admin\/page\/page", "methods": ["POST"]},
        "admin.page.page.show": {
            "uri": "admin\/page\/page\/{page}",
            "methods": ["GET", "HEAD"],
            "parameters": ["page"],
            "bindings": {"page": "id"}
        },
        "admin.page.page.edit": {
            "uri": "admin\/page\/page\/{page}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["page"],
            "bindings": {"page": "id"}
        },
        "admin.page.page.update": {
            "uri": "admin\/page\/page\/{page}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["page"],
            "bindings": {"page": "id"}
        },
        "admin.page.page.destroy": {
            "uri": "admin\/page\/page\/{page}",
            "methods": ["DELETE"],
            "parameters": ["page"],
            "bindings": {"page": "id"}
        },
        "admin.page.widget.index": {"uri": "admin\/page\/widget", "methods": ["GET", "HEAD"]},
        "admin.page.widget.create": {"uri": "admin\/page\/widget\/create", "methods": ["GET", "HEAD"]},
        "admin.page.widget.store": {"uri": "admin\/page\/widget", "methods": ["POST"]},
        "admin.page.widget.show": {
            "uri": "admin\/page\/widget\/{widget}",
            "methods": ["GET", "HEAD"],
            "parameters": ["widget"],
            "bindings": {"widget": "id"}
        },
        "admin.page.widget.edit": {
            "uri": "admin\/page\/widget\/{widget}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["widget"],
            "bindings": {"widget": "id"}
        },
        "admin.page.widget.update": {
            "uri": "admin\/page\/widget\/{widget}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["widget"],
            "bindings": {"widget": "id"}
        },
        "admin.page.widget.destroy": {
            "uri": "admin\/page\/widget\/{widget}",
            "methods": ["DELETE"],
            "parameters": ["widget"],
            "bindings": {"widget": "id"}
        },
        "admin.page.contact.index": {"uri": "admin\/page\/contact", "methods": ["GET", "HEAD"]},
        "admin.page.contact.create": {"uri": "admin\/page\/contact\/create", "methods": ["GET", "HEAD"]},
        "admin.page.contact.store": {"uri": "admin\/page\/contact", "methods": ["POST"]},
        "admin.page.contact.show": {
            "uri": "admin\/page\/contact\/{contact}",
            "methods": ["GET", "HEAD"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.contact.edit": {
            "uri": "admin\/page\/contact\/{contact}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.contact.update": {
            "uri": "admin\/page\/contact\/{contact}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.contact.destroy": {
            "uri": "admin\/page\/contact\/{contact}",
            "methods": ["DELETE"],
            "parameters": ["contact"],
            "bindings": {"contact": "id"}
        },
        "admin.page.gallery.index": {"uri": "admin\/page\/gallery", "methods": ["GET", "HEAD"]},
        "admin.page.gallery.create": {"uri": "admin\/page\/gallery\/create", "methods": ["GET", "HEAD"]},
        "admin.page.gallery.store": {"uri": "admin\/page\/gallery", "methods": ["POST"]},
        "admin.page.gallery.show": {
            "uri": "admin\/page\/gallery\/{gallery}",
            "methods": ["GET", "HEAD"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.edit": {
            "uri": "admin\/page\/gallery\/{gallery}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.update": {
            "uri": "admin\/page\/gallery\/{gallery}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.page.gallery.destroy": {
            "uri": "admin\/page\/gallery\/{gallery}",
            "methods": ["DELETE"],
            "parameters": ["gallery"],
            "bindings": {"gallery": "id"}
        },
        "admin.service.classification.up": {
            "uri": "admin\/service\/classification\/{classification}\/up",
            "methods": ["POST"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.classification.down": {
            "uri": "admin\/service\/classification\/{classification}\/down",
            "methods": ["POST"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.classification.toggle": {
            "uri": "admin\/service\/classification\/{classification}\/toggle",
            "methods": ["POST"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.service.toggle": {
            "uri": "admin\/service\/service\/{service}\/toggle",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.add": {
            "uri": "admin\/service\/service\/{service}\/add",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.del": {
            "uri": "admin\/service\/service\/{service}\/del",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.set": {
            "uri": "admin\/service\/service\/{service}\/set",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.attach-consumable": {
            "uri": "admin\/service\/service\/{service}\/attach-consumable",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.detach-consumable": {
            "uri": "admin\/service\/service\/{service}\/detach-consumable",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.attach": {
            "uri": "admin\/service\/service\/{service}\/attach",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.detach": {
            "uri": "admin\/service\/service\/{service}\/detach",
            "methods": ["POST"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.example.toggle": {
            "uri": "admin\/service\/example\/{example}\/toggle",
            "methods": ["POST"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.add": {
            "uri": "admin\/service\/example\/{example}\/add",
            "methods": ["POST"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.del": {
            "uri": "admin\/service\/example\/{example}\/del",
            "methods": ["POST"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.set": {
            "uri": "admin\/service\/example\/{example}\/set",
            "methods": ["POST"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.attach": {
            "uri": "admin\/service\/example\/{example}\/attach",
            "methods": ["POST"],
            "parameters": ["example"]
        },
        "admin.service.example.detach": {
            "uri": "admin\/service\/example\/{example}\/detach",
            "methods": ["POST"],
            "parameters": ["example"]
        },
        "admin.service.review.toggle": {
            "uri": "admin\/service\/review\/{review}\/toggle",
            "methods": ["POST"],
            "parameters": ["review"],
            "bindings": {"review": "id"}
        },
        "admin.service.extra.toggle": {
            "uri": "admin\/service\/extra\/{extra}\/toggle",
            "methods": ["POST"],
            "parameters": ["extra"],
            "bindings": {"extra": "id"}
        },
        "admin.service.extra.up": {
            "uri": "admin\/service\/extra\/{extra}\/up",
            "methods": ["POST"],
            "parameters": ["extra"],
            "bindings": {"extra": "id"}
        },
        "admin.service.extra.down": {
            "uri": "admin\/service\/extra\/{extra}\/down",
            "methods": ["POST"],
            "parameters": ["extra"],
            "bindings": {"extra": "id"}
        },
        "admin.service.consumable.toggle": {
            "uri": "admin\/service\/consumable\/{consumable}\/toggle",
            "methods": ["POST"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.consumable.attach": {
            "uri": "admin\/service\/consumable\/{consumable}\/attach",
            "methods": ["POST"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.consumable.detach": {
            "uri": "admin\/service\/consumable\/{consumable}\/detach",
            "methods": ["POST"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.extra.index": {"uri": "admin\/service\/extra", "methods": ["GET", "HEAD"]},
        "admin.service.extra.create": {"uri": "admin\/service\/extra\/create", "methods": ["GET", "HEAD"]},
        "admin.service.extra.store": {"uri": "admin\/service\/extra", "methods": ["POST"]},
        "admin.service.extra.show": {
            "uri": "admin\/service\/extra\/{extra}",
            "methods": ["GET", "HEAD"],
            "parameters": ["extra"]
        },
        "admin.service.extra.edit": {
            "uri": "admin\/service\/extra\/{extra}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["extra"]
        },
        "admin.service.extra.update": {
            "uri": "admin\/service\/extra\/{extra}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["extra"],
            "bindings": {"extra": "id"}
        },
        "admin.service.extra.destroy": {
            "uri": "admin\/service\/extra\/{extra}",
            "methods": ["DELETE"],
            "parameters": ["extra"],
            "bindings": {"extra": "id"}
        },
        "admin.service.service.index": {"uri": "admin\/service\/service", "methods": ["GET", "HEAD"]},
        "admin.service.service.create": {"uri": "admin\/service\/service\/create", "methods": ["GET", "HEAD"]},
        "admin.service.service.store": {"uri": "admin\/service\/service", "methods": ["POST"]},
        "admin.service.service.show": {
            "uri": "admin\/service\/service\/{service}",
            "methods": ["GET", "HEAD"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.edit": {
            "uri": "admin\/service\/service\/{service}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.update": {
            "uri": "admin\/service\/service\/{service}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.service.destroy": {
            "uri": "admin\/service\/service\/{service}",
            "methods": ["DELETE"],
            "parameters": ["service"],
            "bindings": {"service": "id"}
        },
        "admin.service.classification.index": {"uri": "admin\/service\/classification", "methods": ["GET", "HEAD"]},
        "admin.service.classification.create": {
            "uri": "admin\/service\/classification\/create",
            "methods": ["GET", "HEAD"]
        },
        "admin.service.classification.store": {"uri": "admin\/service\/classification", "methods": ["POST"]},
        "admin.service.classification.show": {
            "uri": "admin\/service\/classification\/{classification}",
            "methods": ["GET", "HEAD"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.classification.edit": {
            "uri": "admin\/service\/classification\/{classification}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.classification.update": {
            "uri": "admin\/service\/classification\/{classification}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.classification.destroy": {
            "uri": "admin\/service\/classification\/{classification}",
            "methods": ["DELETE"],
            "parameters": ["classification"],
            "bindings": {"classification": "id"}
        },
        "admin.service.example.index": {"uri": "admin\/service\/example", "methods": ["GET", "HEAD"]},
        "admin.service.example.create": {"uri": "admin\/service\/example\/create", "methods": ["GET", "HEAD"]},
        "admin.service.example.store": {"uri": "admin\/service\/example", "methods": ["POST"]},
        "admin.service.example.show": {
            "uri": "admin\/service\/example\/{example}",
            "methods": ["GET", "HEAD"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.edit": {
            "uri": "admin\/service\/example\/{example}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.update": {
            "uri": "admin\/service\/example\/{example}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.example.destroy": {
            "uri": "admin\/service\/example\/{example}",
            "methods": ["DELETE"],
            "parameters": ["example"],
            "bindings": {"example": "id"}
        },
        "admin.service.review.index": {"uri": "admin\/service\/review", "methods": ["GET", "HEAD"]},
        "admin.service.review.create": {"uri": "admin\/service\/review\/create", "methods": ["GET", "HEAD"]},
        "admin.service.review.store": {"uri": "admin\/service\/review", "methods": ["POST"]},
        "admin.service.review.show": {
            "uri": "admin\/service\/review\/{review}",
            "methods": ["GET", "HEAD"],
            "parameters": ["review"],
            "bindings": {"review": "id"}
        },
        "admin.service.review.edit": {
            "uri": "admin\/service\/review\/{review}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["review"],
            "bindings": {"review": "id"}
        },
        "admin.service.review.update": {
            "uri": "admin\/service\/review\/{review}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["review"],
            "bindings": {"review": "id"}
        },
        "admin.service.review.destroy": {
            "uri": "admin\/service\/review\/{review}",
            "methods": ["DELETE"],
            "parameters": ["review"],
            "bindings": {"review": "id"}
        },
        "admin.service.consumable.index": {"uri": "admin\/service\/consumable", "methods": ["GET", "HEAD"]},
        "admin.service.consumable.create": {"uri": "admin\/service\/consumable\/create", "methods": ["GET", "HEAD"]},
        "admin.service.consumable.store": {"uri": "admin\/service\/consumable", "methods": ["POST"]},
        "admin.service.consumable.show": {
            "uri": "admin\/service\/consumable\/{consumable}",
            "methods": ["GET", "HEAD"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.consumable.edit": {
            "uri": "admin\/service\/consumable\/{consumable}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.consumable.update": {
            "uri": "admin\/service\/consumable\/{consumable}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.service.consumable.destroy": {
            "uri": "admin\/service\/consumable\/{consumable}",
            "methods": ["DELETE"],
            "parameters": ["consumable"],
            "bindings": {"consumable": "id"}
        },
        "admin.setting.index": {"uri": "admin\/settings", "methods": ["GET", "HEAD"]},
        "admin.setting.organization": {"uri": "admin\/setting\/organization", "methods": ["GET", "HEAD"]},
        "admin.setting.office": {"uri": "admin\/setting\/office", "methods": ["GET", "HEAD"]},
        "admin.setting.web": {"uri": "admin\/setting\/web", "methods": ["GET", "HEAD"]},
        "admin.setting.notification": {"uri": "admin\/setting\/notification", "methods": ["GET", "HEAD"]},
        "admin.setting.mail": {"uri": "admin\/setting\/mail", "methods": ["GET", "HEAD"]},
        "admin.setting.schedule": {"uri": "admin\/setting\/schedule", "methods": ["GET", "HEAD"]},
        "admin.setting.discount": {"uri": "admin\/setting\/discount", "methods": ["GET", "HEAD"]},
        "admin.setting.update": {"uri": "admin\/setting", "methods": ["PUT"]},
        "admin.user.user.index": {"uri": "admin\/user\/user", "methods": ["GET", "HEAD"]},
        "admin.user.user.create": {"uri": "admin\/user\/user\/create", "methods": ["GET", "HEAD"]},
        "admin.user.user.store": {"uri": "admin\/user\/user", "methods": ["POST"]},
        "admin.user.user.show": {
            "uri": "admin\/user\/user\/{user}",
            "methods": ["GET", "HEAD"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "admin.user.user.edit": {
            "uri": "admin\/user\/user\/{user}\/edit",
            "methods": ["GET", "HEAD"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "admin.user.user.update": {
            "uri": "admin\/user\/user\/{user}",
            "methods": ["PUT", "PATCH"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "admin.user.user.destroy": {
            "uri": "admin\/user\/user\/{user}",
            "methods": ["DELETE"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "admin.user.user.verify": {
            "uri": "admin\/user\/user\/{user}\/verify",
            "methods": ["POST"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "admin.user.find_phone": {"uri": "admin\/user\/user\/find_phone", "methods": ["POST"]},
        "admin.user.user.find": {"uri": "admin\/user\/user\/find", "methods": ["POST"]},
        "admin.user.user.set": {
            "uri": "admin\/user\/user\/{user}\/set",
            "methods": ["POST"],
            "parameters": ["user"],
            "bindings": {"user": "id"}
        },
        "web.login": {"uri": "login", "methods": ["POST"]},
        "web.": {"uri": "sitemap.xml", "methods": ["GET", "HEAD"]},
        "web.login-register": {"uri": "login-register", "methods": ["POST"]},
        "web.logout": {"uri": "logout", "methods": ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"]},
        "web.register.verify": {"uri": "register\/verify", "methods": ["GET", "HEAD"]},
        "web.register": {"uri": "register", "methods": ["GET", "HEAD"]},
        "web.password.request": {"uri": "password\/reset", "methods": ["GET", "HEAD"]},
        "web.password.update": {"uri": "password\/reset", "methods": ["POST"]},
        "web.password.reset": {"uri": "password\/reset\/{token}", "methods": ["GET", "HEAD"], "parameters": ["token"]},
        "web.password.confirm": {"uri": "password\/confirm", "methods": ["GET", "HEAD"]},
        "web.password.": {"uri": "password\/confirm", "methods": ["POST"]},
        "web.password.email": {"uri": "password\/email", "methods": ["POST"]},
        "web.password.phone": {"uri": "password\/phone", "methods": ["POST"]},
        "web.oauth.yandex.callback": {"uri": "oauth\/yandex\/callback", "methods": ["GET", "HEAD"]},
        "web.oauth.yandex": {"uri": "oauth\/yandex", "methods": ["GET", "HEAD"]},
        "web.oauth.telegram.callback": {"uri": "oauth\/telegram\/callback", "methods": ["GET", "HEAD"]},
        "web.oauth.telegram": {"uri": "oauth\/telegram", "methods": ["GET", "HEAD"]},
        "web.oauth.google.callback": {"uri": "oauth\/google\/callback", "methods": ["GET", "HEAD"]},
        "web.oauth.google": {"uri": "oauth\/google", "methods": ["GET", "HEAD"]},
        "web.oauth.vk.callback": {"uri": "oauth\/vk\/callback", "methods": ["GET", "HEAD"]},
        "web.oauth.vk": {"uri": "oauth\/vk", "methods": ["GET", "HEAD"]},
        "web.page.view": {"uri": "page\/{slug}", "methods": ["GET", "HEAD"], "parameters": ["slug"]},
        "web.employee.index": {"uri": "employees", "methods": ["GET", "HEAD"]},
        "web.employee.view": {"uri": "employee\/{slug}", "methods": ["GET", "HEAD"], "parameters": ["slug"]},
        "web.specialization.index": {"uri": "specialization", "methods": ["GET", "HEAD"]},
        "web.specialization.view": {
            "uri": "specialization\/{slug}",
            "methods": ["GET", "HEAD"],
            "parameters": ["slug"]
        },
        "web.test": {"uri": "test", "methods": ["GET", "HEAD"]},
        "web.home": {"uri": "\/", "methods": ["GET", "HEAD"]},
        "web.classification.index": {"uri": "classification", "methods": ["GET", "HEAD"]},
        "web.classification.view": {
            "uri": "classification\/{slug}",
            "methods": ["GET", "HEAD"],
            "parameters": ["slug"]
        },
        "web.service.index": {"uri": "service", "methods": ["GET", "HEAD"]},
        "web.service.view": {"uri": "service\/{slug}", "methods": ["GET", "HEAD"], "parameters": ["slug"]},
        "web.promotion.index": {"uri": "promotion", "methods": ["GET", "HEAD"]},
        "web.promotion.view": {"uri": "promotion\/{slug}", "methods": ["GET", "HEAD"], "parameters": ["slug"]},
        "web.feedback.get-form": {"uri": "feedback\/get-form", "methods": ["POST"]},
        "web.feedback.send-form": {"uri": "feedback\/send-form", "methods": ["POST"]},
        "admin.login": {"uri": "admin\/login", "methods": ["GET", "HEAD"]},
        "admin.": {"uri": "admin\/login", "methods": ["POST"]}
    }
};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export {Ziggy};
