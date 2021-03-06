<ul class="nav">
    @foreach($items as $item)
        @php
            $listItemClass = [];
            $linkAttributes = null;

            $href = $item->link();

            if(url($href) == url()->current()) {
                array_push($listItemClass, 'active');
            }

            $permission = '';
            $hasChildren = false;

            // With Children Attributes
            if(!$item->children->isEmpty())
            {
                foreach($item->children as $child)
                {
                    if(!Auth::user()->can('browse', $item)) {
                        continue;
                    }
                    $hasChildren = $hasChildren || Auth::user()->can('browse', $child);

                    if(url($child->link()) == url()->current())
                    {
                        array_push($listItemClass, 'active');
                    }
                }
                if (!$hasChildren) {
                    continue;
                }

                $linkAttributes = 'href="#' . $item->id .'-dropdown-element" data-toggle="collapse" aria-expanded="'. (in_array('active', $listItemClass) ? 'true' : 'false').'"';
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
            <div id="{{ $item->id }}-dropdown-element" class="collapse {{ (in_array('active', $listItemClass) ? 'in' : '') }}">
                <ul class="nav">
                    @include('layouts.custom-menu-side', ['items' => $item->children, 'options' => $options, 'innerLoop' => true])
                </ul>
            </div>
        @endif
        </li>
    @endforeach
</ul>
