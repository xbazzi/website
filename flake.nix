{
  description = "C and C++";

  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs/nixos-unstable";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs =
    {
      self,
      nixpkgs,
      flake-utils,
      ...
    }:
    flake-utils.lib.eachDefaultSystem (
      system:
      let
        pkgs = import nixpkgs { inherit system; };
        llvm = pkgs.llvmPackages_latest;
        lib = nixpkgs.lib;
        pythonPackages = pkgs.python313Packages;
        pyPkgs = with pythonPackages; [
          pandas
          matplotlib
          numpy
          plotly
          seaborn
        ];

      in
      {
        # devShell = pkgs.mkShell.override { stdenv = pkgs.clangStdenv; } rec {
        devShell = pkgs.mkShell {
          nativeBuildInputs =
            pyPkgs
            ++ (with pkgs; [
              php
              php84Packages.composer
              nodejs_22
            ]);

          shell = pkgs.zsh;
          shellHook = ''
            echo "Welcome to the website flake dev shell" 
            alias jigsaw=" ./vendor/bin/jigsaw"
          '';

          # CPATH = builtins.concatStringsSep ":" [
          #   (lib.makeSearchPathOutput "dev" "include" [ llvm.libcxx ])
          #   (lib.makeSearchPath "resource-root/include" [ llvm.clang ])
          # ];
        };
      }
    );
}
