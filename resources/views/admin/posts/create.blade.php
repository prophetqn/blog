<x-layout>
    <x-setting heading="Publish New Post">
        <form method="POST" action="/admin/posts" enctype="multipart/form-data">
            @csrf
            <x-form.input name="title" required />
            <x-form.input name="thumbnail" type="file" required />
            <x-form.textarea name="excerpt" />
            <x-form.textarea name="body" />
            
            <div class="mb-6">
                <x-form.label name="category_id" />
    
                <select name="category_id" id="category_id">
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ ucwords($category->name) }}</option>
                    @endforeach
                </select>
                
                <x-form.error name="category_id" />
            </div>
    
            <x-form.button>Publish</x-form.button>
        </form>
    </x-setting>
</x-layout>