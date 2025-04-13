
<div class="grid">
 <div class="card card-grid min-w-full">
  <div class="card-header py-5 flex-wrap">
   <h3 class="card-title">
    Static DataTable
   </h3>
   <label class="switch switch-sm">
    <input checked="" class="order-2" name="check" type="checkbox" value="1"/>
    <span class="switch-label order-1">
     Push Alerts
    </span>
   </label>
  </div>
  <div class="card-body">
   <div data-datatable="true" data-datatable-page-size="5" data-datatable-state-save="true" id="datatable_1">
    <div class="scrollable-x-auto">
     <table class="table table-auto table-border" data-datatable-table="true">
      <thead>
       <tr>
        <th class="w-[100px] text-center">
         <span class="sort asc">
          <span class="sort-label">
           Status
          </span>
          <span class="sort-icon">
          </span>
         </span>
        </th>
        <th class="min-w-[185px]">
         <span class="sort">
          <span class="sort-label">
           Last Session
          </span>
          <span class="sort-icon">
          </span>
         </span>
        </th>
        <th class="w-[185px]">
         <span class="sort">
          <span class="sort-label">
           Label
          </span>
          <span class="sort-icon">
          </span>
         </span>
        </th>
        <th class="w-[185px]">
         <span class="sort">
          <span class="sort-label">
           <span class="pt-px" data-tooltip="true" data-tooltip-offset="0, 5px" data-tooltip-placement="top">
            <i class="ki-outline ki-information-2 text-lg leading-none">
            </i>
            <span class="tooltip max-w-48" data-tooltip-content="true">
             Merchant account providers
            </span>
           </span>
           Method
          </span>
          <span class="sort-icon">
          </span>
         </span>
        </th>
        <th class="w-[60px]">
        </th>
        <th class="w-[60px]">
        </th>
       </tr>
      </thead>
      <tbody>
       <tr>
       @foreach (\App\Models\Retro::all() as $retro)
        <tr>
        <td class="text-center">
            <span class="badge badge-dot size-2 bg-success"></span>
        </td>
        <td>
            {{ $retro->created_at->format('d/m/Y') }}
        </td>
        <td>
            {{ $retro->name }}
        </td>
        <td>
            {{$retro->id}}
        </td>
        <td>
            <a class="btn btn-sm btn-icon btn-clear btn-light" href="{{ route('retros.show', $retro->id) }}">
            <i class="ki-outline ki-notepad-edit"></i>
            </a>
        </td>
        <td>
        <form action="{{ route('retros.destroy', $retro->id) }}" method="POST" onsubmit="return confirm('Supprimer cette rétrospective ?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-icon btn-clear btn-light">
                <i class="ki-outline ki-trash"></i>
            </button>
        </form>
        </td>
        </tr>
        @endforeach
       </tr>
       <tr>
         <a class="btn btn-sm btn-icon btn-clear btn-light" href="#">
          <i class="ki-outline ki-notepad-edit">
          </i>
         </a>
        </td>
        <td>
         <a class="btn btn-sm btn-icon btn-clear btn-light" href="#">
          <i class="ki-outline ki-trash">
          </i>
         </a>
        </td>
       </tr>
      </tbody>
     </table>
    </div>
    <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium">
     <div class="flex items-center gap-2">
      Show
      <select class="select select-sm w-16" data-datatable-size="true" name="perpage">
      </select>
      per page
     </div>
     <div class="flex items-center gap-4">
      <span data-datatable-info="true">
      </span>
      <div class="pagination" data-datatable-pagination="true">
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>