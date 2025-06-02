import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz created',
        href: '/quiz-created',
    },
];

type User = {
    id: number;
    name: string;
    email: string;
};

type Question = {
    id: number;
    question_text: string;
    options: any[];
};

type Quiz = {
    id: number;
    name: string;
    thumbnail_url: string | null;
    user: User;
    questions: Question[];
    participants_count?: number;
};

type Props = {
    quizzes: Quiz[];
};

export default function Index() {
    const { props } = usePage<Props>();
    const quizzes: Quiz[] = props.quizzes || [];
    const [selectedQuizId, setSelectedQuizId] = useState<number | null>(null);
    const selectedQuiz = quizzes.find((q) => q.id === selectedQuizId) || null;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz Taken" />

            <div className="flex h-[calc(100vh-100px)] flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Info section – only takes needed height */}
                <div className="shrink-0">
                    <p>Quiz name : {selectedQuiz?.user?.name}</p>
                    <p>Number of questions : {selectedQuiz?.questions?.length ?? 0}</p>
                    <p>Participants : {selectedQuiz?.participants_count ?? 0}</p>
                </div>

                {/* Scrollable box grid – takes remaining height */}
                <div className="flex-1 overflow-auto">
                    <div className="grid grid-cols-4 gap-4">
                        {quizzes.map((quiz) => {
                            const isSelected = quiz.id === selectedQuizId;

                            return (
                                <div
                                    key={quiz.id}
                                    onClick={() => setSelectedQuizId(quiz.id)}
                                    className={`relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border ${
                                        isSelected ? 'border-4 border-red-600' : 'border-sidebar-border/70 dark:border-sidebar-border'
                                    }`}
                                    title={quiz.name}
                                >
                                    {/* Image */}
                                    <img
                                        src={quiz.thumbnail_url ?? 'placeholder-image.jpg'}
                                        alt={quiz.name}
                                        className={`absolute inset-0 h-full w-full object-cover transition duration-300 ${isSelected ? 'brightness-50' : 'brightness-100'}`}
                                    />

                                    {/* Selected Overlay */}
                                    {isSelected && (
                                        <div className="absolute inset-0 flex items-center justify-center">
                                            <span className="text-lg font-bold text-white select-none">Selected</span>
                                        </div>
                                    )}
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
