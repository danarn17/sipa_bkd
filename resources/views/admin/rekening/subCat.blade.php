@foreach ($subcategories as $subcategory)
    <li>
        <span>
            <div class="row">
                <div class="col-9">
                    @if ($subcategory->level_sub !== 5)
                        {{ $subcategory->name }}
                    @else
                        <a
                            href="{{ route('penyerapan.index', ['rekening' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
                    @endif
                    <b>(</b>{{ $no_parent }}<b>{{ $subcategory->no_rek_sub }})</b>
                </div>
                <div class="col-3">
                    @if ($subcategory->level_sub !== 5)
                        <button class="addChild btn btn-primary float-right" data-toggle="modal"
                            data-level={{ $subcategory->level_sub }} data-parent={{ $subcategory->id }}
                            data-rek="{{ $no_parent . $subcategory->no_rek_sub }}" data-target="#tambahChild"> <i
                                class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    @endif
                    <button class="minChild btn btn-danger float-right" data-id={{ $subcategory->id }}
                        data-url="{{ route('rekening.destroy', $subcategory->id) }}"
                        data-level={{ $subcategory->level_sub }}>
                        <i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                </div>
            </div>
        </span>

        @if (count($subcategory->child))
            <ul>
                @include('admin.rekening.subCat',['subcategories' =>
                $subcategory->child,'no_parent'=>$no_parent . $subcategory->no_rek_sub])

            </ul>
        @else

        @endif
    </li>

@endforeach
