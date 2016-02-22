
// thead
document.write('<thead><tr><th>현금계수</th><th>수량</th><th>금액</th></tr></thead>');
document.write('<tbody>');

function ShowCashCalc(num)
{
  var tr = document.getElementById('id_'+num+'_tr');
  var td_unit = document.createElement('td');
  td_unit.id = 'id_'+num+'_td_unit';
  tr.appendChild(td_unit);
  document.getElementById('id_'+num+'_td_unit').innerHTML = num+'원';

  var td_amount = document.createElement('td');
  tr.appendChild(td_amount);
  td_amount.id = 'id_'+num+'_td_amount';
  document.getElementById('id_'+num+'_td_amount').innerHTML = '몇장';

  var td_sum = document.createElement('td');
  td_sum.id = 'id_'+num+'_td_sum';
  tr.appendChild(td_sum);
  document.getElementById('id_'+num+'_td_sum').innerHTML = '얼마';
}

var even = 50000;
var odd = 10000;
even = even*1;
odd = odd*1;

// 동전계수
for(var i=0;i<8;i++)
{
  if(i%2==0)
  {
    ShowCashCalc(even);
    even = even/10;
  }
  else
  {
    ShowCashCalc(odd);
    odd = odd/10;
  }
}




document.write('</tbody>');
