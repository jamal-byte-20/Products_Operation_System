@props(['product'])

<div style="background: white; border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;">
    
    <div style="background-color: #f1f3f5; height: 200px; display: flex; align-items: center; justify-content: center; color: #adb5bd;">
        @if($product->image)
            <img src="{{ $product->image ?? 'https://via.placeholder.com/500x500?text=No+Image' }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <span style="font-size: 0.875rem;">No Image Available</span>
        @endif
    </div>

    <div style="padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.15rem; color: #333;">
                {{ $product->name }}
            </h3>
            <p style="margin: 0 0 1rem 0; font-size: 0.9rem; color: #666; line-height: 1.4;">
                {{ Str::limit($product->description, 80, '...') }}
            </p>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
            <span style="font-size: 1.25rem; font-weight: bold; color: #28a745;">
                ${{ number_format($product->price) ?? number_format($product->price, 2) }}
            </span>
            
            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; background-color: #333; color: white; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                View Details
            </a>
        </div>
    </div>
</div>