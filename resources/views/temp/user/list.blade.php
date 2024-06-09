<table class="table align-middle table-nowrap" id="customerTable">
    <thead>
        <tr>

            <th class="sort" data-sort="email">No</th>
            <th class="sort" data-sort="email">Nama</th>
            <th class="sort" data-sort="phone">Nip</th>
            <th class="sort" data-sort="date">Created At</th>
            <th class="sort" data-sort="status"> Status</th>
            <th class="sort" data-sort="action">Detail</th>
        </tr>
    </thead>
    <tbody class="list form-check-all">
      <?php for ($i=1; $i <100 ; $i++) { ?>
          <tr>


            <td class="customer_name">{{$i}}</td>
            <td class="email">marycousar@SIjuPRI.com</td>
            <td class="phone">580-464-4694</td>
            <td class="date">06 Apr, 2021</td>
            <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Active</span>
            </td>
            <td>
                    <a href=""  class="btn  "> <i class="mdi mdi-eye text-info font-15"></i></a>
            </td>
        </tr>
      <?php }?>
    </tbody>
</table>