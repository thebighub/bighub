begin
declare titre varchar(9);
declare dernier varchar(9);
declare dernier_id int(11);
declare der_texte text;
/* Création du titre */
if new.from < new.to then
	set titre = CONCAT(new.from,'.',new.to);
else
	set titre = CONCAT(new.to,'.',new.from);
end if;
/* Sélection du dernier message entre les 2 users */
set dernier=(select title from `message` where message.title=titre);
set der_texte=(select message_entry.content from message inner join message_entry
on message.id = message_entry.message_id
where message_entry.user_id = new.from and (message.created_by = new.from or message.updated_by = new.from)
order by message_entry.id desc limit 1);
if der_texte <> new.message then
	if dernier is null then /* si ils n'ont pas encore conversé */
		insert into `message`(title, created_at,created_by,updated_at,updated_by)
							     values(titre,new.sent,new.from,new.sent,new.from);
	  set dernier_id = (select id from `message` where 		message.updated_at=new.sent);
		insert into `message_entry`(message_id,user_id,content,created_at,created_by,updated_at,updated_by)
			                   values(dernier_id,new.from,new.message,new.sent,new.from,new.sent,new.from);
		insert into `user_message`(message_id,user_id,is_originator,created_at,created_by,updated_at,updated_by)
			                  values(dernier_id,new.from,1,new.sent,new.from,new.sent,new.from);
		insert into `user_message`(message_id,user_id,created_at,created_by,updated_at,updated_by)
			                  values(dernier_id,new.to,new.sent,new.from,new.sent,new.from);
		else /* Si un message existe déjà */
		update `message` set updated_at=new.sent,updated_by=new.to
			               where title=titre;
		/* sélection du dernier id du message */
	  set dernier_id = (select id from `message` where message.updated_at=new.sent);
	  insert into `message_entry`(message_id,user_id,content,created_at,created_by,updated_at,updated_by)
			                   values(dernier_id,new.from,new.message,new.sent,new.from,new.sent,new.from);
	  update `user_message` set user_message.updated_at=new.sent,user_message.updated_by=new.from
			                    where user_message.message_id=dernier_id and user_message.user_id=new.from;
	end if;
end if;
end




begin
declare from_id int(11);
declare from_nom varchar(30);
declare to_id int(11);
declare to_nom varchar(30);
declare contenu text;

if new.is_originator <> 1 then

insert into frei_chat(from,from_name,to,to_name,message,sent,recd)
values(

end if;


end
