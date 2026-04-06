@extends('layouts.public')

@section('title', 'StageFlow - Visez l\'excellence')

@section('content')
    @include('public.components.stickers')
    @include('public.components.hero')
    @include('public.components.stats')
    @include('public.components.experience')
    @include('public.components.testimonials')
    @include('public.components.faq')
    @include('public.components.cta')
@endsection
