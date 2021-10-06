@extends('layout.app')
@section('title', 'Créer un nouveau article')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ajouter un article</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <form method='POST' action={{ route('articles.store') }}>
                @csrf
                <div class="form-group">
                    <label for="titre" class="text-uppercase @error('titre') is-invalid @enderror">titre</label>
                    <input type="text" id="titre" class="form-control" name="titre" value="" required />
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="description" class="text-uppercase @error('description') is-invalid @enderror">description</label>
                    <input type="text" id="description" class="form-control" name="description" value="" required />
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="contenue" class="text-uppercase @error('contenue') is-invalid @enderror">contenue</label>
                    <input type="text" id="contenue" class="form-control" name="contenue" value="" required />
                    @error('contenue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="form-group" id="user_id">
                    <label for="user_id" class="text-uppercase @error('user_id') is-invalid @enderror">Auteur</label>
                    <select class="form-control" name="user_id" id="user_id">
                        <option value="">---</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="form-group" id="category_id">
                    <label for="category_id" class="text-uppercase @error('category_id') is-invalid @enderror">Categories</label>
                    <select class="form-control" name="category_id[]" id="category_id" multiple>
                        <option value="">---</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="UrlImage" class="text-uppercase @error('UrlImage') is-invalid @enderror">UrlImage</label>
                    <input type="text" id="UrlImage" class="form-control" name="UrlImage" value="" required />
                    @error('UrlImage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div><div class="flex items-center justify-end mt-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-login float-right btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection