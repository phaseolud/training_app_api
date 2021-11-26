<?php
namespace App\Enums;

enum MuscleGroup: string {
    case Quadriceps = 'quadriceps';
    case Hamstrings = 'hamstrings';
    case Calves = 'calves';
    case Glutes = 'glutes';
    case Abs = 'abs';
    case Chest = 'chest';
    case LowerBack = 'lower back';
    case UpperBack = 'upper back';
    case SideDelts = 'side delts';
    case FrontDelts = 'front delts';
    case BackDelts = 'back delts';
}
