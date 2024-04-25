with cte as (
	select 
	 users.empid
     , concat(`users`.`first_name_ar`,' ',coalesce(`users`.`middle_name_ar`,' '),' ',coalesce(`users`.`third_name_ar`,' '),' ',`users`.`family_name_ar`) AS `name`
     , concat(`users`.`first_name_en`,' ',coalesce(`users`.`middle_name_en`,' '),' ',coalesce(`users`.`third_name_en`,' '),' ',`users`.`family_name_en`) AS `name_en`
     , _genders.gender_ar as gender
     , _genders.gender_en as gender_en
     , _sections.section_ar as department
     , _sections.section_en as department_en
     , _countries.country_ar as 'nationality'
     , _countries.country_en as 'nationality_en'
	 , _positions.position_ar as 'position'
     , _positions.position_en as 'position_en'
     , users.joining_date as 'joining date'
 	 , salaries.basic
	 , salaries.housing
	 , salaries.transportation
	 , salaries.food
	 , salaries.effective
	 , (salaries.basic + salaries.housing + salaries.transportation + salaries.food) as package
	 , row_number() over(partition by empid order by effective desc) as rn
     , national_id.document_id as 'id number'
     , passport.document_id as 'pass_num'
     , if(users.sponsorship_id = 3 , 'Non-sponsored', 'Sponsored') as sponsorship
     , banks.iban
     , _banks.bank_name_en
	 , _banks.bank_name_ar
     , users.vacation_class
     , mobile.contact as mobile
     , email.contact as personal_email
     , users.active as job_status
     , users.resignation_date
	from users
	left join salaries on salaries.user_id = users.id
    left join (select user_id, document_id from documents where document_type_id = 1) national_id on national_id.user_id = users.id
	left join (select user_id, document_id from documents where document_type_id = 2) passport on passport.user_id = users.id
    left join (select user_id, contact  from contacts where type = 1) mobile on mobile.user_id = users.id
	left join (select user_id, contact  from contacts where type = 2) email on email.user_id = users.id
    left join banks on banks.user_id = users.id
	left join _banks on _banks.id = banks.bank_code
    left join _genders on _genders.id = users.gender_id
    left join _sections on _sections.id = users.section_id
    left join _countries on _countries.id = users.nationality_id
    left join _positions on _positions.id = users.position_id)
select 
	cte.* , round(if((to_days(curdate()) - to_days(`cte`.`joining date`)) / 365 >= 5,`cte`.`package` * 5 / 2 + ((to_days(curdate()) - to_days(`cte`.`joining date`)) / 365 - 5) * `cte`.`package`,`cte`.`package` * (to_days(curdate()) - to_days(`cte`.`joining date`)) / 365 / 2),2) AS `benefits`
from cte where rn = 1;