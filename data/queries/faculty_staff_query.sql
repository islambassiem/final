SET @start_date = '2023-09-01';
SET @end_date = '2024-06-30';
select 
	u.empid '#'
    , d.name 'الاسم'
    , u.email 'البريد الالكتروني'
    , c.contact 'الجوال'
    , doc.document_id 'الهوية'
    , 'كليات العناية الطبية' AS 'الكلية'
    , _sections.section_ar 'القسم'
    , 'العلوم الطبية التطبيقية' AS 'المجال التعليمي'
    , _positions.position_ar
from users u 
left join mail_merge_letters d using (empid)
left join contacts c on c.user_id = u.id 
left join documents doc on doc.user_id = u.id 
left join _sections on _sections.id = u.section_id
left join _positions on _positions.id = u.position_id
where u.category_id in (1, 2)
	and c.type = 1
    and doc.document_type_id = 1
    and u.joining_date <=  @end_date
    and (u.resignation_date >= @start_date or u.active = 1)
order by u.empid;