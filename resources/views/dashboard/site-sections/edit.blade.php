@extends('dashboard.layouts.master')

@section('title', 'Edit Section: ' . $siteSection->key)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit Section: {{ $siteSection->key }}</h4>
            <a href="{{ route('admin.site-sections.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('admin.site-sections.update', $siteSection) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php $key = $siteSection->key; @endphp

                            {{-- Generic fields, but we only show what's needed per section --}}

                            {{-- Title --}}
                            @if (!in_array($key, ['about_why']))
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $siteSection->title) }}">
                                    @error('title')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Subtitle (banner / hero / story etc.) --}}
                            @if (in_array($key, [
                                    'about_banner',
                                    'about_hero',
                                    'about_story',
                                    'about_why',
                                    'home_hero',
                                    'home_cruises',
                                    'home_day_tours',
                                    'home_desert',
                                    'home_egypt_jordan',
                                    'home_redsea',
                                ]))
                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control"
                                        value="{{ old('subtitle', $siteSection->subtitle) }}">
                                    @error('subtitle')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Description (long text sections: hero/story/home sections) --}}
                            @if (in_array($key, [
                                    'about_hero',
                                    'about_story',
                                    'home_hero',
                                    'home_cruises',
                                    'home_day_tours',
                                    'home_desert',
                                    'home_egypt_jordan',
                                    'home_redsea',
                                ]))
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="5" class="form-control">{{ old('description', $siteSection->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- About Why cards – simple fields instead of raw JSON --}}
                            @if ($key === 'about_why')
                                @php
                                    $cards = [];
                                    if (old('cards')) {
                                        $cards = old('cards');
                                    } elseif ($siteSection->content) {
                                        $decoded = json_decode($siteSection->content, true);
                                        if (is_array($decoded)) {
                                            $cards = $decoded;
                                        }
                                    }
                                    if (count($cards) === 0) {
                                        $cards = [
                                            [
                                                'icon' => 'fa-solid fa-globe',
                                                'title' => 'Global Reach',
                                                'text' =>
                                                    'Serving travelers from USA, UK, Australia & worldwide with seamless booking and support.',
                                                'color' => 'blue',
                                            ],
                                            [
                                                'icon' => 'fa-solid fa-user-check',
                                                'title' => 'Expert Guides',
                                                'text' =>
                                                    'Professional Egyptologist guides for every journey — history, culture, and hidden gems.',
                                                'color' => 'gold',
                                            ],
                                            [
                                                'icon' => 'fa-solid fa-clock',
                                                'title' => '24/7 Support',
                                                'text' =>
                                                    'Local support ensuring a seamless travel experience from arrival to departure.',
                                                'color' => 'green',
                                            ],
                                            [
                                                'icon' => 'fa-solid fa-location-dot',
                                                'title' => 'Handpicked',
                                                'text' =>
                                                    'Carefully selected hotels and luxury Nile cruises for comfort and authenticity.',
                                                'color' => 'blue',
                                            ],
                                        ];
                                    }
                                @endphp

                                <div class="mb-3">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>Cards (Why Travel With Us)</span>
                                        <span class="text-muted small">غير العنوان / النص / الأيقونة لكل كارت</span>
                                    </label>

                                    @foreach ($cards as $i => $card)
                                        <div class="border rounded p-3 mb-2">
                                            <div class="mb-2">
                                                <label class="form-label small">Title</label>
                                                <input type="text" name="cards[{{ $i }}][title]"
                                                    class="form-control" value="{{ $card['title'] ?? '' }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Text</label>
                                                <textarea name="cards[{{ $i }}][text]" rows="2" class="form-control">{{ $card['text'] ?? '' }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label small">Icon class (اختياري)</label>
                                                    <input type="text" name="cards[{{ $i }}][icon]"
                                                        class="form-control" value="{{ $card['icon'] ?? '' }}"
                                                        placeholder="مثال: fa-solid fa-globe">
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label small">Color (blue / gold / green)</label>
                                                    <input type="text" name="cards[{{ $i }}][color]"
                                                        class="form-control" value="{{ $card['color'] ?? '' }}"
                                                        placeholder="blue">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Button fields (only for sections that have buttons) --}}
                            @if (in_array($key, ['home_hero', 'home_cruises', 'home_day_tours', 'home_desert', 'home_egypt_jordan', 'home_redsea']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" name="button_text" class="form-control"
                                                value="{{ old('button_text', $siteSection->button_text) }}">
                                            @error('button_text')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Link</label>
                                            <input type="text" name="button_link" class="form-control"
                                                value="{{ old('button_link', $siteSection->button_link) }}">
                                            @error('button_link')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active"
                                        {{ old('status', $siteSection->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $siteSection->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image (only for sections that use images) --}}
                            @if (in_array($key, ['home_hero', 'home_cruises', 'home_desert', 'home_egypt_jordan', 'home_redsea', 'about_hero']))
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    @if ($siteSection->image_path)
                                        <div class="mt-2">
                                            <img src="{{ asset($siteSection->image_path) }}" alt="Section image"
                                                class="img-fluid rounded" style="max-height: 160px;">
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">Info</h6>
                        <p class="text-muted small mb-1">
                            <strong>Key:</strong> <code>{{ $siteSection->key }}</code>
                        </p>
                        <p class="text-muted small mb-0">
                            استخدم هذا السكشن علشان تغير العنوان، الوصف، الزر، والصورة في واجهة الموقع.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
