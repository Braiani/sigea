<ul class="nav">
    @foreach($items as $item)
        @php
            $listItemClass = [];
            $linkAttributes = null;
            $transItem = $item;

            $href = $item->link();

            if(url($href) == url()->current()) {
                array_push($listItemClass, 'active');
            }

            $hasChildren = false;

            // With Children Attributes
            if(!$item->children->isEmpty())
            {
                foreach($item->children as $child)
                {
                    $hasChildren = $hasChildren || Auth::user()->can('browse', $child);

                    if(url($child->link()) == url()->current())
                    {
                        array_push($listItemClass, 'active');
                    }
                }
                if (!$hasChildren) {
                    continue;
                }

                $linkAttributes = 'href="#' . $transItem->id .'-dropdown-element" data-toggle="collapse" aria-expanded="'. (in_array('active', $listItemClass) ? 'true' : 'false').'"';
                array_push($listItemClass, 'dropdown');
            }
            else
            {
                $linkAttributes =  'href="' . url($href) .'"';

                if(!Auth::user()->can('browse', $item)) {
                    continue;
                }
            }
        @endphp
        <li class="nav-item {{ implode(" ", $listItemClass) }}" >
            <a {!! $linkAttributes !!} class="nav-link" target="{{ $item->target }}">
                <i class="nc-icon {{$item->icon_class}}"></i>
                <p>{{ $item->title }}@if ($hasChildren) <b class="caret"></b> @endif</p>
            </a>
            @if($hasChildren)
            <div id="{{ $transItem->id }}-dropdown-element" class="collapse {{ (in_array('active', $listItemClass) ? 'in' : '') }}">
                <ul class="nav">
                    <li class="nav-item">
                        @include('layouts.custom-menu-side', ['items' => $item->children, 'options' => $options, 'innerLoop' => true])
                    </li>
                </ul>
            </div>
        @endif
        </li>
    @endforeach
</ul>
