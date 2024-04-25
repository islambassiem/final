with cte as (
	select 
	 users.empid
	 , salaries.basic
	 , salaries.housing
	 , salaries.transportation
	 , salaries.food
	 , salaries.effective
	 , (salaries.basic + salaries.housing + salaries.transportation + salaries.food) as package
	 , row_number() over(partition by empid order by effective desc) as rn
     , documents.document_id as id
     , if(users.sponsorship_id =3 , 'Non-sponsored', 'Sponsored') as sponsorship
     , banks.iban
     , _banks.bank_code
	from users
	join salaries on salaries.user_id = users.id
    join documents on documents.user_id = users.id
    left join banks on banks.user_id = users.id
	left join _banks on _banks.id = banks.bank_code
	where active = 1)
select 
	empid, basic, housing, transportation, food, package, effective, id, sponsorship, iban, bank_code
from cte
where rn = 1;
