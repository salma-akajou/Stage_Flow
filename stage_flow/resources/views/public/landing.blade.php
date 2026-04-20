@extends('layouts.public')

@section('title', 'StageFlow - Visez l\'excellence')

@section('content')
    @include('components.public.stickers')
    @include('components.public.hero')
    @include('components.public.stats')
    @include('components.public.experience')
    @include('components.public.testimonials')
    @include('components.public.faq')
    @include('components.public.cta')
@endsection
