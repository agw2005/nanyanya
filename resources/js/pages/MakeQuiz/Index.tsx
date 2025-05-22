import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Toggle } from '@/components/ui/toggle';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Make new quiz',
        href: '/make',
    },
];

export default function Index() {
    const [quizName, setQuizName] = useState('');
    const [thumbnailUrl, setThumbnailUrl] = useState<string>('');
    const [questionCount, setQuestionCount] = useState(2); // default 2 questions
    const [questions, setQuestions] = useState<Record<number, string>>({});
    const [correctAnswers, setCorrectAnswers] = useState<Record<number, string>>({});
    const [options, setOptions] = useState<Record<number, Record<string, string>>>({});

    const handleQuestionCountChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = parseInt(e.target.value, 10);
        if (!isNaN(value) && value > 0) {
            setQuestionCount(value);
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        const payload = {
            name: quizName,
            thumbnail_url: thumbnailUrl,
            questions: Array.from({ length: questionCount }).map((_, index) => {
                const opts = options[index] || {};
                return {
                    question_text: questions[index] || '',
                    options: ['A', 'B', 'C', 'D'].map((label) => ({
                        label,
                        option_text: opts[label] || '',
                        is_correct: correctAnswers[index] === label,
                    })),
                };
            }),
        };

        console.log('Quiz Payload:', payload);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Make new quiz" />
            <div className="m-10">
                <form onSubmit={handleSubmit}>
                    <div className="mt-1 pt-1">
                        <Label htmlFor="Quiz name">Quiz Name</Label>
                        <Input id="quiz-name" value={quizName} onChange={(e) => setQuizName(e.target.value)} placeholder="Ex: PyTorch Exam" />
                    </div>

                    <div className="mt-1 pt-1">
                        <Label htmlFor="Quiz thumbnail">Quiz Thumbnail URL</Label>
                        <Input
                            id="quiz-thumbnail-url"
                            type="text"
                            value={thumbnailUrl}
                            onChange={(e) => setThumbnailUrl(e.target.value)}
                            placeholder="https://picsum.photos/id/237/500/300"
                        />
                    </div>
                    {thumbnailUrl && (
                        <div className="mt-2">
                            <div className="relative mt-2 aspect-[2/1] w-full max-w-md overflow-hidden rounded border">
                                <img src={thumbnailUrl} alt="Quiz Thumbnail" className="absolute inset-0 size-full object-cover" />
                            </div>
                        </div>
                    )}

                    <div className="mt-1 pt-1">
                        <Label htmlFor="Quiz question quantity">Questions Quantity</Label>
                        <Input
                            id="questions-quantity"
                            type="number"
                            value={questionCount}
                            onChange={handleQuestionCountChange}
                            placeholder="Ex: 10"
                        />
                    </div>

                    {Array.from({ length: questionCount }).map((_, index) => (
                        <div key={index} className="mt-4 pt-4">
                            <div>
                                <Label htmlFor={`question-${index}`}>Question {index + 1} - Question</Label>
                                <Textarea
                                    id={`question-${index}`}
                                    placeholder={`Ex: What is ${index}+${index}?`}
                                    value={questions[index] || ''}
                                    onChange={(e) =>
                                        setQuestions((prev) => ({
                                            ...prev,
                                            [index]: e.target.value,
                                        }))
                                    }
                                />
                            </div>
                            {['A', 'B', 'C', 'D'].map((option) => (
                                <div key={option}>
                                    <div className="flex items-center gap-2">
                                        <Label htmlFor={`question-${index}-option-${option}`}>
                                            Question {index + 1} - Option {option}
                                        </Label>
                                        <Toggle
                                            pressed={correctAnswers[index] === option}
                                            onClick={() => {
                                                setCorrectAnswers((prev) => ({
                                                    ...prev,
                                                    [index]: option,
                                                }));
                                            }}
                                        >
                                            Correct Answer
                                        </Toggle>
                                    </div>
                                    <Input
                                        id={`question-${index}-option-${option}`}
                                        placeholder={`Option ${option}`}
                                        value={options[index]?.[option] ?? ''}
                                        onChange={(e) =>
                                            setOptions((prev) => ({
                                                ...prev,
                                                [index]: {
                                                    ...(prev[index] || {}),
                                                    [option]: e.target.value,
                                                },
                                            }))
                                        }
                                    />
                                </div>
                            ))}
                        </div>
                    ))}

                    <Button type="submit" className="mt-4">
                        Create Quiz
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
