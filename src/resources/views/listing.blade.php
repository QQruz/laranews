{{-- If you know how to inject model from config please let me know--}}
@inject('request', \QQruz\Laranews\Request)
<style>
#laranews-listing td, #laranews-listing tbody th{
    cursor:pointer;
}

#laranews-listing tr:hover > .laranews-controls{
    visibility:visible
}

.laranews-editable {
    cursor:text;
    background:white;
    color: black;
    min-height: 15px;
    min-width: 15px;
    display:block;
}

#laranews-listing tbody tr {
    position:relative
}

.laranews-controls {
    position:sticky;
    right:0;
    visibility:hidden;
}

.laranews-controls button {
    margin:1px;
}

</style>
<div class="table-responsive" id="laranews-listing">
    <table class="table table-striped table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">id</th>
                @foreach($request::make()->getFillable() as $column)
                <th scope="col">{{$column}}</th>
                @endforeach
                <th scope="col">created_at</th>
                <th scope="col">updated_at</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($request::all() as $request)
                <tr>
                    @foreach($request->getAttributes() as $key => $value)
                        @if($key === 'id')
                            <th scope="row" title="double click to edit">
                                <span data-key="{{$key}}">{{$value}}</span>
                            </th>
                        @else
                            <td title="double click to edit">
                                <span data-key="{{$key}}">{{$value}}</span>
                            </td>    
                        @endif
                    @endforeach
                    <td class="laranews-controls">
                        <form class="laranews-update" action="{{config('laranews.routes.update')}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="_id" value="{{$request->id}}">
                            <Button class="btn btn-light">Submit</Button>
                        </form>

                        <form action="{{config('laranews.routes.delete')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <Button class="btn btn-danger">Delete</Button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
(function (){
    const $container = document.querySelector('#laranews-listing')
    const $cells = $container.querySelectorAll('td, tbody th')


    const enable = element => {
        element.contentEditable = true
        element.classList.add('laranews-editable')
        element.focus()
    }

    const disable = element => {
        element.contentEditable = false
        element.classList.remove('laranews-editable')
    }

    const createInput = element => {
        const $form = element.closest('tr').querySelector('.laranews-update')
        let $input = $form.querySelector('input[name=' + element.dataset.key + ']')
        
        if (!$input) {
            $input = document.createElement('input')
            $input.name = element.dataset.key
            $input.type = 'hidden'
            $form.append($input)
        }
        
        $input.value = element.textContent      
    }

    const outOfFocus = element => {
        disable(element)
        createInput(element)
    }

    $cells.forEach(cell => {
        const $span = cell.querySelector('span')
        cell.addEventListener('dblclick', e => {
            enable($span)
        })
        cell.addEventListener('focusout', e => {
            outOfFocus($span)
        })
        cell.addEventListener('keydown', e => {
            if (e.keyCode === 13 || e.keyCode === 27) {
                outOfFocus($span)
            }
        })
    })
})();

</script>